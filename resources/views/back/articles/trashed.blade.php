@extends('back.layouts.master')
@section('title','Silinen Makaleler')
@section('content')
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">@yield('title')
                <span class="float-right"> Toplam {{$articles->count()}} makale bulundu.
            <a href="{{route('admin.makaleler.index')}}" class="btn btn-primary btn-sm float-right">
                <i class="fa fa-reply-all"></i> Tüm Makaleler
            </a>
                </span>
            </h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                    <tr>
                        <th>Fotoğraf</th>
                        <th>Makale Başlığı</th>
                        <th>Kategori</th>
                        <th>Hit</th>
                        <th>Oluşturma Tarihi</th>
                        <th>İşlemler</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($articles as $article)
                        <tr>
                            <td><img src="{{asset($article->image)}}" title="{{$article->image}}" width="150"></td>
                            <td>{{$article->title}}</td>
                            <td>{{$article->getCategory->name}}</td>
                            <td>{{$article->hit}}</td>
                            <td>{{$article->created_at->diffForHumans()}}</td>
                            <td nowrap="">
                                <a href="{{route('admin.article.recovery',$article->id)}}" title="Geri Yükle"
                                   class="btn btn-sm btn-primary"><i class="fa fa-xs fa-recycle"></i>
                                </a>
                                <a href="{{route('admin.article.hardDelete',$article->id)}}" title="Sil"
                                   class="btn btn-sm btn-danger"><i class="fa fa-xs fa-times"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('css')

@endsection
@section('js')

@endsection
