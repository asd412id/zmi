<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Link extends Model
{
	use HasFactory;
	protected $table = 'link';

	public function category()
	{
		return $this->belongsTo(Category::class);
	}
	public function getActiveAttribute($value)
	{
		return '<span class="badge ' . ($value ? 'badge-primary' : 'badge-danger') . '">' . ($value ? 'Aktif' : 'Tidak Aktif') . '</span>';
	}
	public function getLinkAttribute($value)
	{
		return '<button class="btn badge badge-primary get-link" title="Klik untuk menyalin Link">' . url($value ?? "/") . '</button>';
	}
	public function getActiveValAttribute()
	{
		return $this->attributes['active'];
	}
	public function getLinkValAttribute()
	{
		return $this->attributes['link'];
	}
	public function getColorAttribute()
	{
		return @Config::where('config', 'link_' . $this->id . '_color')->first()->value;
	}
}
