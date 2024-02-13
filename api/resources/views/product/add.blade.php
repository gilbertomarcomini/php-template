@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
            	<ol class="breadcrumb panel-heading">
                	<li><a href="{{route('product.index')}}">Produtos</a></li>
                	<li class="active">Adicionar</li>
                </ol>
                <div class="panel-body">
	                <form action="{{ route('product.save') }}" method="POST" enctype="multipart/form-data">
	                	{{ csrf_field() }}
						<div class="form-group">
						  	<label for="name">Nome</label>
						    <input type="text" class="form-control" name="name" id="name" placeholder="Nome">
						</div>
                        <div class="form-group">
                            <label for="name">Categorias</label>
                            <select name="category[]" class="form-control selectpicker" multiple="" data-live-search="true" title="Categorias">
                                @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach()
                            </select>
                            <p class="help-block">Use Crtl para selecionar.</p>
                        </div>
                        <div class="control-group input-images">
                            <button type="button" class="btn btn-info" id="moreimages">Mais...</button>
                            <br />
                            <br />
                            <div class="controls">
                                <input name="images[]" type="file">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="description">Descrição</label>
                            <textarea class="form-control" rows="3" name="description" id="description"></textarea>
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
