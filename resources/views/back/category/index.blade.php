@extends('back.layouts.master')
@section('title','Tüm Kategoriler')
@section('content')

    <div class="row">
        <div class="col-md-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Yeni Kategori Ekle</h6>
                </div>
                <div class="card-body">
                    <form action="{{route('admin.category.create')}}" method="post">
                        @csrf
                        <div class="form-group">
                            <input type="text" class="form-control" name="category" required>
                        </div>
                        <div class="form-group">
                            <input type="submit" class="btn btn-block btn-primary" value="Ekle">
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">@yield('title')</h6>
                </div>
                <div class="card-body">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                        <tr>
                            <th>Kategori Adı</th>
                            <th>Makale Adet</th>
                            <th>Durum</th>
                            <th>İşlemler</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($categories as $category)
                            <tr>
                                <td>{{$category->name}}</td>
                                <td>{{$category->articleCount()}}</td>
                                <td><input class="swichButon" kategori-id="{{$category->id}}" type="checkbox"
                                           @if($category->status==1) checked @endif data-toggle="toggle"
                                           data-on="<i class='fa fa-play'></i> Aktif"
                                           data-off="<i class='fa fa-play'></i> Pasif"
                                           data-onstyle="success" data-offstyle="danger"
                                    ></td>
                                <td nowrap>
                                    <a href="#" kategori-id="{{$category->id}}"
                                       class="btn btn-primary btn-sm btnEdit"><i class="fa fa-edit"></i></a>
                                    <a href="#" kategori-id="{{$category->id}}"
                                       article-count="{{$category->articleCount()}}" kategori-name="{{$category->name}}"
                                       class="btn btn-danger btn-sm btnKatSil"><i class="fa fa-times"></i></a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>


    <!-- Modal -->
    <div class="modal fade" id="categoryEditModal" tabindex="-1" role="dialog" aria-labelledby="categoryEditModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="categoryEditModalLabel">Kategori Düzenle</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{route('admin.category.update')}}" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="col-form-label-sm">Kategori Adı</label>
                            <input type="text" id="kategori" name="kategori" class="form-control">
                            <input type="hidden" id="id" name="id" class="form-control">
                        </div>
                        <div class="form-group">
                            <label class="col-form-label-sm">Kategori Slug</label>
                            <input type="text" id="slug" name="slug" class="form-control">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Kapat</button>
                        <button type="submit" class="btn btn-primary">Güncelle</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <!-- Modal -->
    <div class="modal fade" id="categorySilModal" tabindex="-1" role="dialog" aria-labelledby="categorySilModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="categorySilModalLabel">Kategori Sil</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div id="bildirimBody" class="modal-body">
                    <div id="bildirimler" class="alert alert-danger"></div>
                </div>
                <form action="{{route('admin.category.sil')}}" method="post">
                    @csrf
                    <input type="hidden" name="deletedID" id="deletedID" value="">
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Kapat</button>
                        <button id="deleteButon" type="submit" class="btn btn-primary">Sil</button>
                    </div>
                </form>
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
        $(function () {
            $('.swichButon').change(function () {

                id = $(this)[0].getAttribute('kategori-id');
                statu = $(this).prop('checked');
                $.get("{{route('admin.category.switch')}}", {id: id, statu: statu}, function (data, status) {
                });
            })

            $('.btnKatSil').click(function () {
                id = $(this)[0].getAttribute('kategori-id');
                count = $(this)[0].getAttribute('article-count');
                nameK = $(this)[0].getAttribute('kategori-name');
                $('#bildirimler').html('');
                $('#bildirimBody').hide();
                $('#deletedID').val('');

                if (id == 1) {
                    $('#deleteButon').hide();
                    $('#bildirimBody').show();
                    $('#bildirimler').html(nameK + ' kategorisi silinemez. Diğer silinen kategorilerdeki makaleler buraya taşınır.');
                    $('#categorySilModal').modal();
                    return;
                }
                if (count > 0) {
                    $('#deletedID').val(id);
                    $('#bildirimBody').show();
                    $('#deleteButon').show();
                    $('#bildirimler').html('Bu kategoriye ait ' + count + ' adet makale bulunmaktadır. Silmek istediğinize emin misiniz?');
                    $('#categorySilModal').modal();
                    return;
                }
                $('#deletedID').val(id);
                $('#bildirimBody').hide();
                $('#deleteButon').show();
                $('#categorySilModal').modal();

            })

            $('.btnEdit').click(function () {
                id = $(this)[0].getAttribute('kategori-id');
                //alert(id);
                $.ajax({
                    type: 'GET',
                    url: '{{route('admin.category.getdata')}}',
                    data: {id: id},
                    success: function (data) {
                        //console.log(data);
                        $('#kategori').val(data.name);
                        $('#slug').val(data.slug);
                        $('#id').val(data.id);
                        $('#categoryEditModal').modal();
                    }
                })
            })

            $('#slug').dblclick(function () {
                slug = $('#kategori').val();
                $(this).val(slug);
            })

        })
    </script>
@endsection
