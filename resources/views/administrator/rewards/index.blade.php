@extends('layouts.administrator')
@section('title', 'Выплаты')

@push('page-styles')
<link rel="stylesheet" href="{{asset('veneto/css/plugins/jquery-dataTables.min.css')}}">
<style>
	.table .table { background-color: #fff; }

	.dataTables_wrapper { position: relative; }

	.dataTables_processing { position: absolute; top: 50%; left: 50%; width: 100%; height: 40px; margin-left: -50%; margin-top: -25px; padding-top: 20px; text-align: center; font-size: 1.2em; background-color: white; background: -webkit-gradient(linear, left top, right top, color-stop(0%, rgba(255, 255, 255, 0)), color-stop(25%, rgba(255, 255, 255, 0.9)), color-stop(75%, rgba(255, 255, 255, 0.9)), color-stop(100%, rgba(255, 255, 255, 0))); background: -webkit-linear-gradient(left, rgba(255, 255, 255, 0) 0%, rgba(255, 255, 255, 0.9) 25%, rgba(255, 255, 255, 0.9) 75%, rgba(255, 255, 255, 0) 100%); background: -moz-linear-gradient(left, rgba(255, 255, 255, 0) 0%, rgba(255, 255, 255, 0.9) 25%, rgba(255, 255, 255, 0.9) 75%, rgba(255, 255, 255, 0) 100%); background: -ms-linear-gradient(left, rgba(255, 255, 255, 0) 0%, rgba(255, 255, 255, 0.9) 25%, rgba(255, 255, 255, 0.9) 75%, rgba(255, 255, 255, 0) 100%); background: -o-linear-gradient(left, rgba(255, 255, 255, 0) 0%, rgba(255, 255, 255, 0.9) 25%, rgba(255, 255, 255, 0.9) 75%, rgba(255, 255, 255, 0) 100%); background: linear-gradient(to right, rgba(255, 255, 255, 0) 0%, rgba(255, 255, 255, 0.9) 25%, rgba(255, 255, 255, 0.9) 75%, rgba(255, 255, 255, 0) 100%) }
</style>

@endpush

@push('page-scripts')

<script src="{{asset('veneto/assets/plugins/jquery-datatables/js/jquery.dataTables.js')}}"></script>
<script src="{{asset('veneto/assets/plugins/jquery-datatables/js/dataTables.tableTools.js')}}"></script>
<script src="{{asset('veneto/assets/plugins/jquery-datatables/js/dataTables.bootstrap.js')}}"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/handlebars.js/4.0.6/handlebars.min.js"></script>
{!! $dataTable->scripts() !!}

<script>
	var template = Handlebars.compile($("#details-template").html());
	$('#dataTableBuilder').addClass('table-striped');
	var dataTables = window.LaravelDataTables['dataTableBuilder'];
	$('#dataTableBuilder tbody').on('click', 'td.dt-details-control', function () {
		var tr = $(this).closest('tr');
		var row = dataTables.row(tr);

		if(row.child.isShown()) {
			row.child.hide();
			tr.removeClass('shown');
		}
		else {
			console.log(row.data());
			row.child(template(row.data())).show();
			tr.addClass('shown');
		}

	});
</script>
@endpush

@section('page')

	<div class="container-fluid-md">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h4 class="panel-title">Список выплат</h4>
			</div>
			<div class="panel-body">
				{!! $dataTable->table([], true) !!}
			</div>
		</div>
	</div>

	<script id="details-template" type="text/x-handlebars-template">
		<table class="table no-margin">
			<tr>
				<td>User ID:</td>
				<td>@{{{user_link}}}</td>
			</tr>
			<tr>
				<td>Виплата за:</td>
				<td>@{{{title}}}</td>
			</tr>
			<tr>
				<td>Сумма:</td>
				<td>@{{{data.amount}}}</td>
			</tr>
			<tr>
				<td>Описание:</td>
				<td>@{{{body}}}</td>
			</tr>
			<tr>
				<td>Дата выплаты:</td>
				<td>@{{created_at}}</td>
			</tr>
		</table>
	</script>

@endsection

