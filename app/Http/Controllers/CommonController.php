<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Config;
use App\Models\Link;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class CommonController extends BaseController
{
	use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

	public function login()
	{
		$data = [
			'title' => 'Halaman Login'
		];
		return view('login', $data);
	}

	public function loginProcess(Request $r)
	{
		$rules = [
			'email' => 'required',
			'password' => 'required',
		];

		$msgs = [
			'email.required' => 'Email tidak boleh kosong!',
			'password.required' => 'Password tidak boleh kosong!',
		];

		validator($r->all(), $rules, $msgs)->validate();

		if (!Auth::attempt(['email' => $r->email, 'password' => $r->password], (bool) $r->remember)) {
			return redirect()->back()->withErrors('Email dan password tidak benar!');
		}

		return redirect()->route('home');
	}

	public function logout()
	{
		auth()->logout();
		return redirect()->route('login');
	}

	public function home()
	{
		$data = [
			'title' => 'Beranda',
			'cat' => Category::count(),
			'link' => Link::count(),
		];
		return view('home', $data);
	}
	public function account()
	{
		$data = [
			'title' => 'Pengaturan Akun',
			'user' => auth()->user(),
			'configs' => Config::configs(),
		];
		return view('account', $data);
	}

	public function accountUpdate(Request $r)
	{
		$rules = [
			'name' => 'required',
			'email' => 'required|email',
			'password' => 'required',
			'newpassword' => 'confirmed',
		];

		$msgs = [
			'name.required' => 'Nama tidak boleh kosong!',
			'email.required' => 'Email tidak boleh kosong!',
			'email.email' => 'Format alamat email tidak benar!',
			'password.required' => 'Password tidak boleh kosong!',
			'newpassword.confirmed' => 'Perulangan password tidak benar!',
		];

		$r->validate($rules, $msgs);

		$user = auth()->user();

		if (!Hash::check($r->password, $user->password)) {
			return redirect()->back()->withErrors('Password tidak benar!')->withInput();
		}

		$user->name = $r->name;
		$user->email = $r->email;
		if ($r->newpassword) {
			$user->password = bcrypt($r->newpassword);
		}

		if ($user->save()) {
			return redirect()->back()->with('success', 'Data Akun berhasil diubah!');
		}
		return redirect()->back()->withErrors('Data Akun gagal diubah!');
	}
	public function configsUpdate(Request $r)
	{
		$data = [];
		foreach ($r->all() as $key => $v) {
			if ($key == '_token') {
				continue;
			}
			array_push($data, [
				'config' => $key,
				'value' => $v
			]);
		}

		Config::truncate();
		$insert = Config::insert($data);

		if ($insert) {
			return redirect()->back()->with('success', 'Pengaturan berhasil diperbaharui');
		}
		return redirect()->back()->withErrors('Pengaturan gagal disimpan');
	}

	public function index()
	{
		$configs = Config::configs();
		$data = [
			'title' => env('APP_NAME') . ' | ' . (@$configs->lembaga ?? 'UPTD SMP NEGERI 39 SINJAI'),
			'category' => Category::where('active', 1)->whereHas('links')->get(),
			'ulinks' => Link::whereNull('category_id')
				->orderBy('position', 'asc')
				->orderBy('name', 'asc')
				->get(),
			'configs' => $configs
		];

		return view('homepage', $data);
	}
}
