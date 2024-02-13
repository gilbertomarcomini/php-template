@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <ol class="breadcrumb panel-heading">
                        <li class="active">Categorias</li>
                    </ol>
                    <div class="panel-body">
                        <form class="form-inline" action="{{ route('category.search') }}" method="POST">
                            {{ csrf_field() }}
                            <input type="hidden" name="_method" value="put">
                            <div class="form-group" style="float: right;">
                                <p><a href="{{route('category.add')}}" class="btn btn-info btn-sm"><i
                                            class="glyphicon glyphicon-plus"></i> Adicionar</a></p>
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" id="name" name="name" placeholder="Categoria"
                                       value="{{ (isset($search) ? $search : null)  }}">
                            </div>
                            <button type="submit" class="btn btn-default"><i class="glyphicon glyphicon-search"></i>
                                Buscar
                            </button>
                        </form>
                        <br/>
                        <table class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>Cod</th>
                                <th width="20">Imagem</th>
                                <th>Nome</th>
                                <th>Ação</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($categories as $category)
                                <tr>
                                    <th scope="row" class="text-center">{{ $category->id }}</th>
                                    <td class="center">
                                        <img src="{{ url('/') }}/images/category/{{ $category->image }}" width="100%"/>
                                    </td>
                                    <td>{{ $category->name }}</td>
                                    <td width="155" class="text-center">
                                        <a href="{{route('category.edit', $category->id)}}" class="btn btn-default">Editar</a>
                                        <a href="{{route('category.delete', $category->id)}}" class="btn btn-danger">Excluir</a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <div align="center">
                            {!! is_object($categories) && method_exists($categories, 'links') ? $categories->links() : null !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
