@extends('front.layouts.master')
@section('title', 'İrtibat')
@section('bg', 'https://www.troax.com/sites/default/files/styles/header_image_desktop_/public/2019-08/Contact_header_2880x1000px.jpg?itok=9hgrfHuH')
@section('content')

    <div class="col-md-8 mx-auto">

        @if(session('success'))
            <div class="alert alert-success">
                {{session('success')}}
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach($errors->all() as $error)
                    <li>{{$error}}</li>
                    @endforeach
                </ul>
            </div>
        @endif


        <p>Bizimle iletişime geçebilirsiniz.</p>
        <form method="post" action="{{Route('contact.post')}}">
            @csrf
            <div class="control-group">
                <div class="form-group controls">
                    <label>Ad Soyad</label>
                    <input type="text" class="form-control" value="{{old('name')}}" placeholder="Ad Soyad" name="name"
                           required>
                    <p class="help-block text-danger"></p>
                </div>
            </div>
            <div class="control-group">
                <div class="form-group controls">
                    <label>Email Adresi</label>
                    <input type="email" class="form-control" value="{{old('email')}}" placeholder="Email Adresi"
                           name="email" required>
                    <p class="help-block text-danger"></p>
                </div>
            </div>
            <div class="control-group">
                <div class="form-group col-xs-12 controls">
                    <label>Konu</label>
                    <select class="form-control" name="topic">
                        <option @if(old('topic')=="Bilgi") selected @endif >Bilgi</option>
                        <option @if(old('topic')=="İstek") selected @endif >İstek</option>
                        <option @if(old('topic')=="Genel") selected @endif >Genel</option>
                    </select>
                </div>
            </div>
            <div class="control-group">
                <div class="form-group controls">
                    <label>Mesajınız</label>
                    <textarea rows="5" class="form-control" placeholder="Mesajınız" name="message"
                              required>{{old('message')}}</textarea>
                    <p class="help-block text-danger"></p>
                </div>
            </div>
            <br>
            <div id="success"></div>
            <button type="submit" class="btn btn-primary" name="sendMessageButton">Send</button>
        </form>
    </div>

    <div class="col-md-4">
        <div class="card" style="width: 18rem;">
            <div class="card-body">
                <h5 class="card-title">Hakan Özdemir</h5>
                <h6 class="card-subtitle mb-2 text-muted">www.hakkan.net</h6>
                <p class="card-text">Paran varsa gerisi goley.</p>
                <a href="#" class="card-link">hakan07ant@gmail.com</a>
                <a href="#" class="card-link">0530 821 0322</a>
            </div>
        </div>
    </div>

@endsection









