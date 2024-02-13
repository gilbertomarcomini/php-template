@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
            	<ol class="breadcrumb panel-heading">
                	<li><a href="{{route('product.index')}}">Produtos</a></li>
                	<li class="active">Editar</li>
                </ol>
                <div class="panel-body">
	                <form action="{{ route('product.update', $product->id) }}" method="POST" enctype="multipart/form-data">
	                	{{ csrf_field() }}
						<div class="form-group">
						  	<label for="name">Nome</label>
						    <input type="text" class="form-control" name="name" id="name" placeholder="Nome" value="{{ $product->name }}">
						</div>
                        <div class="form-group">
                            <label for="name">Categorias</label>
                            <select name="categories[]" class="form-control selectpicker" multiple="" data-live-search="true" title="Categorias">
                                <?php foreach($categories as $category){ ?>
                                    <option value="<?= $category->id ?>" <?= in_array($category->id, $selected) ? "selected" : NULL ; ?>><?= $category->name ?></option>
                                <?php } ?>
                            </select>
                            <p class="help-block">Use Crtl para selecionar.</p>
                        </div>
                        <div class="form-group">
                            <label for="name">Imagens</label>
                            <br/>
                            @foreach($images as $image)
                            <img src="{{ url('/') }}/images/product/{{ $image->image }}"  width="10%" />
                            @endforeach
                        </div>
                        <div class="control-group">
                            <button type="button" class="btn btn-info btn-xs" id="moreimages"><i class="glyphicon glyphicon-plus"></i></button>
                            <br>
                            <div class="controls input-images">
                                <input name="images[]" type="file">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="description">Descrição</label>
                            <textarea class="form-control" rows="3" name="description" id="description">{{ $product->description }}</textarea>
                        </div>
						<br />
						<button type="submit" class="btn btn-primary">Salvar</button>
	                </form>
                    <br />
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
