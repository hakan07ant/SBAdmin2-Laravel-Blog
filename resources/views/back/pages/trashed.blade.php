@extends('back.layouts.master')
@section('title','Silinen Sayfalar')
@section('content')
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">@yield('title')
                <span class="float-right"> Toplam {{$pages->count()}} sayfa bulundu.
            <a href="{{route('admin.sayfalar.index')}}" class="btn btn-primary btn-sm float-right">
                <i class="fa fa-reply-all"></i> Tüm Sayfalar
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
                        <th>Sayfa Başlığı</th>
                        <th>Oluşturma Tarihi</th>
                        <th>İşlemler</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($pages as $page)
                        <tr>
                            <td><img src="{{asset($page->image)}}" title="{{$page->image}}" width="150"></td>
                            <td>{{$page->title}}</td>
                            <td>{{$page->created_at->diffForHumans()}}</td>
                            <td nowrap="">
                                <a href="{{route('admin.sayfa.recovery',$page->id)}}" title="Geri Yükle"
                                   class="btn btn-sm btn-primary"><i class="fa fa-xs fa-recycle"></i>
                                </a>
                                <a href="{{route('admin.sayfa.hardDelete',$page->id)}}" title="Sil"
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
