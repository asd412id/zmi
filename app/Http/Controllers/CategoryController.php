<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Config;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Str;
use DataTables;

class CategoryController extends Controller
{
	use AuthorizesRequests, ValidatesRequests;
	public function index()
	{
		if (request()->ajax()) {
			$data = Category::query()
				->with('links');
			return DataTables::of($data)
				->addColumn('linkscount', function ($row) {
					return $row->links->count();
				})
				->addColumn('action', function ($row) {

					$btn = '<div class="table-actions">';

					$btn .= ' <a href="' . route('category.form', ['uuid' => $row->uuid]) . '" class="text-primary m-1 edit" title="Ubah"><i class="fas fa-edit"></i></a>';

					$btn .= ' <a href="' . route('category.destroy', ['uuid' => $row->uuid]) . '" class="text-danger m-1 confirm" data-text="Hapus ' . $row->name . '?" title="Hapus"><i class="fas fa-trash"></i></a>';

					$btn .= '</div>';

					return $btn;
				})
				->rawColumns(['active', 'action'])
				->make(true);
		}
		$data = [
			'title' => 'Kategori Link',
		];
		return view('category.index', $data);
	}

	public function form($uuid = null)
	{
		if (request()->ajax()) {
			$cat = Category::where('uuid', $uuid)->first();
			ob_start();
?>
			<form id="form" action="<?= $uuid ? route('category.update', ['uuid' => $uuid]) : route('category.store') ?>">
				<?= csrf_field() ?>
				<div class="form-group">
					<label for="iname">Nama Kategori</label>
					<input type="text" name="name" class="form-control" id="iname" value="<?= @$cat->name ?>">
				</div>
				<div class="form-group">
					<label for="idesc">Deskripsi</label>
					<textarea name="description" id="idesc" class="form-control" rows="3"><?= @$cat->description ?></textarea>
				</div>
				<div class="form-group">
					<label for="ipos">Urutan</label>
					<select name="position" class="form-control">
						<?php if (!Category::count()) : ?>
							<option value="1">1</option>
						<?php else : ?>
							<?php for ($i = 0; $i <= Category::count(); $i++) : ?>
								<option <?= @$cat->position == ($i + 1) ? 'selected' : '' ?> value="<?= ($i + 1) ?>"><?= ($i + 1) ?></option>
							<?php endfor; ?>
						<?php endif; ?>
					</select>
				</div>
				<div class="form-group">
					<label>Warna</label>
					<div class="input-group cpicker">
						<input type="text" class="form-control" name="color" value="<?php echo @$cat->color ?>">
						<div class="input-group-append">
							<span class="input-group-text"><i class="fas fa-square" style="color: <?= @$cat->color ?? '#fff' ?>;"></i></span>
						</div>
					</div>
				</div>
				<div class="form-group">
					<label for="istatus">Status</label>
					<select name="active" class="form-control">
						<option <?= !is_null(@$cat->active_val) && @$cat->active_val == 1 ? 'selected' : '' ?> value="1">Aktif</option>
						<option <?= !is_null(@$cat->active_val) && @$cat->active_val == 0 ? 'selected' : '' ?> value="0">Tidak Aktif</option>
					</select>
				</div>
				<button type="submit" class="btn btn-block btn-primary">Simpan</button>
			</form>
<?php
			$form = ob_get_clean();

			$data = [
				'title' => $cat ? 'Ubah Kategori ' . $cat->name : 'Kategori Baru',
				'form' => $form
			];

			return response()->json($data);
		}
	}

	public function store(Request $r)
	{
		$r->validate([
			'name' => 'required'
		], [
			'name.required' => 'Nama kategori tidak boleh kosong!'
		]);

		$insert = new Category;
		$insert->uuid = (string) Str::uuid();
		$insert->name = $r->name;
		$insert->description = $r->description;
		$insert->position = $r->position;
		$insert->active = $r->active;

		if ($insert->save()) {
			$color = new Config;
			$color->config = 'cat_' . $insert->id . '_color';
			$color->value = $r->color;
			$color->save();
			return response()->json(['message' => 'Data berhasil disimpan']);
		}
		return response()->json(['message' => 'Data gagal disimpan!'], 500);
	}
	public function update($uuid, Request $r)
	{
		$r->validate([
			'name' => 'required'
		], [
			'name.required' => 'Nama kategori tidak boleh kosong!'
		]);

		$insert = Category::where('uuid', $uuid)->first();
		$insert->name = $r->name;
		$insert->description = $r->description;
		$insert->position = $r->position;
		$insert->active = $r->active;

		if ($insert->save()) {
			$color = Config::where('config', 'cat_' . $insert->id . '_color')->first();
			if (!$color) {
				$color = new Config;
			}
			$color->config = 'cat_' . $insert->id . '_color';
			$color->value = $r->color;
			$color->save();
			return response()->json(['message' => 'Data berhasil disimpan']);
		}
		return response()->json(['message' => 'Data gagal disimpan!'], 500);
	}
	public function destroy($uuid)
	{
		$delete = Category::where('uuid', $uuid)->first();
		if ($delete->delete()) {
			$color = Config::where('config', 'cat_' . $delete->id . '_color')->first();
			$color->delete();
			return response()->json(['message' => 'Data berhasil dihapus']);
		}
		return response()->json(['message' => 'Data gagal dihapus'], 500);
	}
}
