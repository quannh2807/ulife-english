<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::orderBy('id', 'DESC')->paginate(PAGE_SIZE);

        return view('admin.users.index', [
            'data' => $users,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        $data = $request->all();
        if ($request->hasFile('avatar')) {
            $path = $request->file('avatar')->store('users', 'public');
            $avatarImg = $path;
            $data['avatar'] = $avatarImg;
        }
        $data['created_by'] = Auth::user()->id;
        $data['updated_by'] = Auth::user()->id;
        $data['password'] = Hash::make('password');
        $this->userRepository->storeNew($data);

        return redirect()->route('admin.user.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = $this->userRepository->findById($id, []);

        return view('admin.users.update', [
            'user' => $user,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $data = $request->except('_token');
        if ($request->hasFile('avatar')) {
            $path = $request->file('avatar')->store('users', 'public');
            $avatarImg = $path;
            $data['avatar'] = $avatarImg ? $avatarImg : '';
        }
        $data['updated_by'] = Auth::user()->id;
        $this->userRepository->update($data['id'], $data);

        return redirect()->route('admin.user.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::where('id', $id)->exists();
        if ($user) {
            $this->userRepository->deleteById($id);

            return redirect()->route('admin.user.index');
        }
    }

    public function search(Request $request)
    {
        DB::enableQueryLog();
        $users = User::query();
        if (!empty(request('keyword'))) {
            $users->where('acc_name', 'LIKE', '%' . request('keyword') . '%');
            $users->orWhere('id', request('keyword'));
        }

        if (!empty(request('email'))) {
            $users->where('email', 'LIKE', '%' . request('email') . '%');
        }

        if (request('status') >= 0) {
            $users->where('status', request('status'));
        }
        $data = $users->orderBy('id', 'DESC')->paginate(10);

        return view('admin.users.index', [
            'data' => $data,
        ]);
    }
}
