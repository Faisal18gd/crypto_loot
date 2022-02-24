<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
class Withdrawreq extends Model
{
	public $timestamps = false;
    protected $fillable = ['id', 'user', 'currency', 'network', 'address','points', 'is_cash', 'ip_address', 'date', 'completed'];
}
?>
