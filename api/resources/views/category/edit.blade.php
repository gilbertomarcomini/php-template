@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
            	<ol class="breadcrumb panel-heading">
                	<li><a href="{{route('category.index')}}">Categorias</a></li>
                	<li class="active">Editar</li>
                </ol>
                <div class="panel-body">
	                <form action="{{ route('category.update', $category->id) }}" method="POST" enctype="multipart/form-data">
	                	{{ csrf_field() }}
						<div class="form-group">
						  	<label for="name">Nome</label>
						    <input type="text" class="form-control" name="name" id="name" placeholder="Nome" value="{{ $category->name }}">
						</div>
                        <div class="form-group">
                            <img src="http://192.168.22.10/laravel/public/images/category/{{ $category->image }}"  width="10%" />
                            <input type="hidden" name="deleteimage" value="{{ $category->image }}">
                        </div>
                        <div class="control-group">
                            <div class="controls">
                                <input name="image" type="file">
                            </div>
                        </div>
						<br />
						<button type="submit" class="btn btn-primary">Salvar</button>
	                </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
