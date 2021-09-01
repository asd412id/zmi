<?php

namespace App\Http\Controllers;

use App\Models\Link;
use App\Models\Category;
use App\Models\Config;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Str;
use DB;
use DataTables;

class LinkController extends Controller
{
	use AuthorizesRequests, ValidatesRequests;

	protected $forbidden_link = ['login', 'logout', 'home', 'category', 'link', 'account', 'configs', 'store'];
	public function index()
	{
		if (request()->ajax()) {
			$data = Link::query()
				->with('category');
			return DataTables::of($data)
				->addColumn('dcat', function ($row) {
					return $row->category ? $row->category->name : '-';
				})
				->addColumn('action', function ($row) {

					$btn = '<div class="table-actions">';

					$btn .= ' <a href="' . route('link.form', ['uuid' => $row->uuid]) . '" class="text-primary m-1 edit" title="Ubah"><i class="fas fa-edit"></i></a>';

					$btn .= ' <a href="' . route('link.destroy', ['uuid' => $row->uuid]) . '" class="text-danger m-1 confirm" data-text="Hapus ' . $row->name . '?" title="Hapus"><i class="fas fa-trash"></i></a>';

					$btn .= '</div>';

					return $btn;
				})
				->rawColumns(['link', 'active', 'action'])
				->make(true);
		}
		$data = [
			'title' => 'Daftar Link',
		];
		return view('link.index', $data);
	}

	public function form($uuid = null)
	{
		if (request()->ajax()) {
			$link = Link::where('uuid', $uuid)->first();
			ob_start();
?>
			<form id="form" action="<?= $uuid ? route('link.update', ['uuid' => $uuid]) : route('link.store') ?>">
				<?= csrf_field() ?>
				<div class="form-group">
					<label for="icat">Kategori</label>
					<select id="icat" name="category_id" class="form-control">
						<option value="null">Tanpa Kategori</option>
						<?php foreach (Category::all() as $value) : ?>
							<option <?= @$link->category_id == $value->id ? 'selected' : '' ?> value="<?= $value->uuid ?>"><?= $value->name ?></option>
						<?php endforeach; ?>
					</select>
				</div>
				<div class="form-group">
					<label for="iname">Nama Link</label>
					<input type="text" name="name" class="form-control" id="iname" value="<?= @$link->name ?>">
				</div>
				<div class="form-group">
					<label for="idesc">Deskripsi</label>
					<textarea name="description" id="idesc" class="form-control" rows="3"><?= @$link->description ?></textarea>
				</div>
				<div class="form-group">
					<label for="ilink">Url</label>
					<div class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text" id="basic-addon3"><?= url('/') ?>/</span>
						</div>
						<input type="text" name="link" value="<?= @$link->link_val ?? \Str::random(7) ?>" class="form-control" placeholder="random">
					</div>
				</div>
				<div class="form-group">
					<label for="idest">Link Tujuan</label>
					<textarea id="idest" name="destination" class="form-control" rows="3"><?= @$link->destination ?></textarea>
				</div>
				<div class="form-group">
					<label for="ipos">Urutan</label>
					<select name="position" class="form-control">
						<?php if (!Link::count()) : ?>
							<option value="1">1</option>
						<?php else : ?>
							<?php for ($i = 0; $i <= Link::count(); $i++) : ?>
								<option <?= @$link->position == ($i + 1) ? 'selected' : '' ?> value="<?= ($i + 1) ?>"><?= ($i + 1) ?></option>
							<?php endfor; ?>
						<?php endif; ?>
					</select>
				</div>
				<div class="form-group">
					<label for="istatus">Status</label>
					<select name="active" class="form-control">
						<option <?= !is_null(@$link->active_val) && @$link->active_val == 1 ? 'selected' : '' ?> value="1">Aktif</option>
						<option <?= !is_null(@$link->active_val) && @$link->active_val == 0 ? 'selected' : '' ?> value="0">Tidak Aktif</option>
					</select>
				</div>
				<button type="submit" class="btn btn-block btn-primary">Simpan</button>
			</form>
<?php
			$form = ob_get_clean();

			$data = [
				'title' => $link ? 'Ubah Link ' . $link->name : 'Link Baru',
				'form' => $form
			];

			return response()->json($data);
		}
	}

	public function generate($length = 5, $count = 1)
	{
		$slug = Str::random($length);
		$cek = Link::where('link', $slug)->first();
		if ($cek) {
			if ($count == ($length * 62)) {
				$length++;
			}
			$count++;
			return $this->generate($length, $count);
		}
		return $slug;
	}

	public function store(Request $r)
	{
		$r->validate([
			'name' => 'required',
			'link' => 'required',
			'destination' => 'required',
		], [
			'name.required' => 'Nama link tidak boleh kosong!',
			'link.required' => 'URL tidak boleh kosong!',
			'destination.required' => 'Link tujuan tidak boleh kosong!',
		]);

		if (!filter_var($r->destination, FILTER_VALIDATE_URL)) {
			return response()->json(['message' => 'Link tujuan tidak valid! Contoh alamat yang benar: https://www.google.com atau https://google.com'], 406);
		}

		$cek = Link::where('link', Str::titleSlug($r->link))->count();

		if ($cek || in_array(Str::titleSlug($r->link), $this->forbidden_link)) {
			return response()->json(['message' => 'Url telah digunakan!'], 406);
		}

		$insert = new Link;
		$insert->uuid = (string) Str::uuid();
		$insert->name = $r->name;
		$insert->description = $r->description;
		$insert->category_id = @Category::where('uuid', $r->category_id)->first()->id ?? null;
		$insert->link =
			Str::titleSlug($r->link ?? $this->generate());
		$insert->destination = $r->destination;
		$insert->position = $r->position;
		$insert->active = $r->active;

		if ($insert->save()) {
			return response()->json(['message' => 'Data berhasil disimpan']);
		}
		return response()->json(['message' => 'Data gagal disimpan!'], 500);
	}
	public function update($uuid, Request $r)
	{
		$r->validate([
			'name' => 'required',
			'link' => 'required',
			'destination' => 'required',
		], [
			'name.required' => 'Nama link tidak boleh kosong!',
			'link.required' => 'url tidak boleh kosong!',
			'destination.required' => 'Link tujuan tidak boleh kosong!',
		]);

		if (!filter_var($r->destination, FILTER_VALIDATE_URL)) {
			return response()->json(['message' => 'Link tujuan tidak valid! Contoh alamat yang benar: https://www.google.com atau https://google.com'], 406);
		}

		$cek = Link::where('link', Str::titleSlug($r->link))
			->where('uuid', '!=', $uuid)
			->count();

		if ($cek || in_array(Str::titleSlug($r->link), $this->forbidden_link)) {
			return response()->json(['message' => 'Url telah digunakan!'], 406);
		}

		$insert = Link::where('uuid', $uuid)->first();
		$insert->name = $r->name;
		$insert->description = $r->description;
		$insert->category_id = @Category::where('uuid', $r->category_id)->first()->id ?? null;
		$insert->link =
			Str::titleSlug($r->link ?? $this->generate());
		$insert->destination = $r->destination;
		$insert->position = $r->position;
		$insert->active = $r->active;

		if ($insert->save()) {
			return response()->json(['message' => 'Data berhasil disimpan']);
		}
		return response()->json(['message' => 'Data gagal disimpan!'], 500);
	}
	public function destroy($uuid)
	{
		$delete = Link::where('uuid', $uuid)->first();
		if ($delete->delete()) {
			return response()->json(['message' => 'Data berhasil dihapus']);
		}
		return response()->json(['message' => 'Data gagal dihapus'], 500);
	}
	public function goto($custom)
	{
		$link = Link::where('link', Str::titleSlug($custom))
			->first();
		if ($link) {
			$link->hits += 1;
			$link->save();
		}
		return response()->view('goto', [
			'title' => $link ? $link->name : 'Link tidak ditemukan',
			'configs' => Config::configs(),
			'ulinks' => Link::whereNull('category_id')
				->orderBy('position', 'asc')
				->orderBy('name', 'asc')
				->get(),
			'link' => $link,
		])->setStatusCode($link ? ($link->active_val ? 200 : 403) : 404);
	}
}
