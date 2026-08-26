<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Core\Services\UserService;
use App\Models\User;
use App\Exports\UsersExport;
use App\Mail\WelcomeEmail;
use App\Mail\UserNotificationEmail;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\App;

class UserController extends Controller
{
    protected $service;

    public function __construct(UserService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request)
    {
        $search = $request->search;
        $status = $request->status;
        $fromDate = $request->from_date;
        $toDate = $request->to_date;

        $users = $this->service->listUsers($search, $status, $fromDate, $toDate);

        $totalUsers = User::count();
        $todayUsers = User::whereDate('created_at', today())->count();
        $activeUsers = User::where('status', 'active')->count();
        $inactiveUsers = $this->service->getInactiveUsersCount();
        $weeklyUsers = $this->service->getWeeklyUsersCount();
        $monthlyUsers = $this->service->getMonthlyUsersCount();

        $chartLabels = [];
        $chartData = [];
        $growthData = $this->service->getUserGrowthData();
        foreach ($growthData as $data) {
            $chartLabels[] = date('M d', strtotime($data->date));
            $chartData[] = $data->count;
        }

        return view('users.index', compact(
            'users',
            'search',
            'status',
            'fromDate',
            'toDate',
            'totalUsers',
            'todayUsers',
            'activeUsers',
            'inactiveUsers',
            'weeklyUsers',
            'monthlyUsers',
            'chartLabels',
            'chartData'
        ));
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'status' => 'required'
        ]);

        $user = $this->service->storeUser(
            $request->only('name', 'email', 'status')
        );

        if (env('MAIL_ENABLED', false)) {
            Mail::to($user->email)->send(new WelcomeEmail($user));
            Mail::to(env('ADMIN_EMAIL', 'admin@example.com'))->send(new UserNotificationEmail($user, 'created'));
        }

        return redirect()
            ->route('users.index')
            ->with('success', __('messages.user_created'));
    }

    public function edit($id)
    {
        $user = $this->service->getUser($id);
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $this->service->updateUser(
            $id,
            $request->only('name', 'email', 'status')
        );

        $user = $this->service->getUser($id);

        if (env('MAIL_ENABLED', false)) {
            Mail::to(env('ADMIN_EMAIL', 'admin@example.com'))->send(new UserNotificationEmail($user, 'updated'));
        }

        return redirect()
            ->route('users.index')
            ->with('success', __('messages.user_updated'));
    }

    public function destroy($id)
    {
        $this->service->deleteUser($id);

        return redirect()
            ->route('users.index')
            ->with('success', __('messages.user_deleted'));
    }

    public function exportCSV(Request $request)
    {
        $users = $this->service->listAllUsers(
            $request->search,
            $request->status,
            $request->from_date,
            $request->to_date
        );

        $filename = 'users_' . date('Y_m_d_His') . '.csv';

        $callback = function () use ($users) {
            $handle = fopen('php://output', 'w');

            fprintf($handle, chr(0xEF) . chr(0xBB) . chr(0xBF));
            fputcsv($handle, [
                'ID',
                'Name',
                'Email',
                'Status',
                'Created At',
                'Updated At'
            ]);

            foreach ($users as $user) {
                fputcsv($handle, [
                    $user->id,
                    $user->name,
                    $user->email,
                    ucfirst($user->status),
                    $user->created_at ? $user->created_at->format('Y-m-d H:i:s') : '',
                    $user->updated_at ? $user->updated_at->format('Y-m-d H:i:s') : '',
                ]);
            }

            fclose($handle);
        };

        return response()->streamDownload($callback, $filename, [
            'Content-Type' => 'text/csv; charset=UTF-8',
        ]);
    }

    public function exportExcel(Request $request)
    {
        $users = $this->service->listAllUsers(
            $request->search,
            $request->status,
            $request->from_date,
            $request->to_date
        );

        return Excel::download(
            new UsersExport($users),
            'users_' . date('Y_m_d_His') . '.xlsx'
        );
    }

    public function exportPDF(Request $request)
    {
        $users = $this->service->listAllUsers(
            $request->search,
            $request->status,
            $request->from_date,
            $request->to_date
        );

        $pdf = Pdf::loadView('users.pdf', compact('users'))
            ->setPaper('a4', 'landscape');

        return $pdf->download('users_' . date('Y_m_d_His') . '.pdf');
    }

    public function printView(Request $request)
    {
        $users = $this->service->listAllUsers(
            $request->search,
            $request->status,
            $request->from_date,
            $request->to_date
        );

        return view('users.print', compact('users'));
    }

    public function switchLanguage($lang)
    {
        if (in_array($lang, ['en', 'gu', 'hi'])) {
            session(['locale' => $lang]);
            App::setLocale($lang);
        }
        return redirect()->back();
    }

    public function toggleTheme()
    {
        $current = session('theme', 'dark');
        $newTheme = $current === 'dark' ? 'light' : 'dark';
        session(['theme' => $newTheme]);
        return redirect()->back();
    }
}
