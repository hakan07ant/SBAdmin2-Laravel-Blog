@extends('back.layouts.master')
@section('title','Tüm Sayfalar')
@section('content')
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">@yield('title')
                <span class="float-right"> Toplam <stron>{{$pages->count()}}</stron> sayfa bulundu
            <a href="{{route('admin.trashed.page')}}" class="btn btn-warning btn-sm float-right"><i
                    class="fa fa-trash"></i> Silinen Sayfalar</a></span></h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <div id="siralamaSuccess" class="alert alert-success" style="display: none"> Sıralama güncellendi.</div>
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                    <tr>
                        <th style="width: 1%;">Sıra</th>
                        <th style="width: 1%;">Fotoğraf</th>
                        <th>Sayfa Başlığı</th>
                        <th>Oluşturma Tarihi</th>
                        <th style="width: 1%;">Durum</th>
                        <th style="width: 1%;">İşlemler</th>
                    </tr>
                    </thead>
                    <tbody id="sortable">
                    @foreach($pages as $page)
                        <tr id="sayfaTR_{{$page->id}}">
                            <td class="text-center"><i id="handle" class="fa fa-expand-arrows-alt"></i></td>

                            <td style="padding: 0px; margin: 0px; text-align: center;"><img class="img-thumbnail"
                                                                                            src="{{asset($page->image)}}"
                                                                                            title="{{$page->image}}"
                                                                                            width="100"></td>
                            <td>{{$page->title}}</td>
                            <td>{{$page->created_at->diffForHumans()}}</td>
                            <td><input class="swichButon" article-id="{{$page->id}}" type="checkbox"
                                       @if($page->status==1) checked @endif data-toggle="toggle"
                                       data-on="<i class='fa fa-play'></i> Aktif"
                                       data-off="<i class='fa fa-play'></i> Pasif"
                                       data-onstyle="success" data-offstyle="danger"
                                ></td>
                            <td nowrap="">
                                <a href="{{route('page',$page->slug)}}" target="_blank" title="Görüntüle"
                                   class="btn btn-sm btn-circle btn-success"><i
                                        class="fa fa-xs fa-eye"></i> </a>
                                <a href="{{route('admin.sayfalar.edit',$page->id)}}" title="Düzenle"
                                   class="btn btn-sm btn-primary"><i class="fa fa-xs fa-pen"></i> </a>
                                <a href="{{route('admin.sayfa.delete',$page->id)}}" title="Silinen Sayfalara Taşı"
                                   class="btn btn-sm btn-info"><i class="fa fa-xs fa-trash"></i>
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

    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

@endsection
@section('js')

    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script>
        $(function () {
            $("#sortable").sortable({
                placeholder: "ui-state-highlight",
                handle: "#handle",
                update: function () {
                    var siralama = $("#sortable").sortable('serialize');
                    $.get("{{route("admin.sayfa.sirala")}}?" + siralama, function (data, status) {
                    });
                    //console.log(siralama);

                    $('#siralamaSuccess').show().delay(2000).fadeOut();
                }
            });
            $("#sortable").disableSelection();
        });
    </script>


    <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>

    <script>
        $(function () {
            $('.swichButon').change(function () {
                id = $(this)[0].getAttribute('article-id');
                statu = $(this).prop('checked');
                $.get("{{route('admin.DurumSwitchPage')}}", {id: id, statu: statu}, function (data, status) {
                });
            })
        })
    </script>
@endsection

