@extends('back.layouts.master')
@section('title','Tüm Makaleler')
@section('content')
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">@yield('title')
                <span class="float-right"> Toplam <stron>{{$articles->count()}}</stron> makale bulundu
            <a href="{{route('admin.trashed.article')}}" class="btn btn-warning btn-sm float-right"><i class="fa fa-trash"></i> Silinen Makaleler</a></span></h6>
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
                        <th>Durum</th>
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
                            <td><input class="swichButon" article-id="{{$article->id}}" type="checkbox"
                                       @if($article->status==1) checked @endif data-toggle="toggle"
                                       data-on="<i class='fa fa-play'></i> Aktif"
                                       data-off="<i class='fa fa-play'></i> Pasif"
                                       data-onstyle="success" data-offstyle="danger"
                                ></td>
                            <td nowrap="">
                                <a href="{{route('single',[$article->getCategory->slug,$article->slug])}}" target="_blank" title="Görüntüle" class="btn btn-sm btn-circle btn-success"><i
                                        class="fa fa-xs fa-eye"></i> </a>
                                <a href="{{route('admin.makaleler.edit',$article->id)}}" title="Düzenle"
                                   class="btn btn-sm btn-primary"><i class="fa fa-xs fa-pen"></i> </a>
                                <a href="{{route('admin.article.delete',$article->id)}}" title="Silinen Makalelere Taşı" class="btn btn-sm btn-info"><i class="fa fa-xs fa-trash"></i>
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
    <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
@endsection
@section('js')
    <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>

    <script>
        $(function() {
            $('.swichButon').change(function() {

               id = $(this)[0].getAttribute('article-id');
               statu = $(this).prop('checked');

                $.get("{{route('admin.DurumSwitch')}}", {id:id, statu:statu}, function(data, status){});
            })
        })
    </script>
@endsection
