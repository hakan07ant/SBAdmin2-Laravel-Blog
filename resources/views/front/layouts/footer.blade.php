</div>
</div>

<hr>

<!-- Footer -->
<footer>
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-md-10 mx-auto">
                <ul class="list-inline text-center">
                    @php $sosyals=['facebook','youtube','instagram','twitter','linkedin','github','gitlab'] @endphp

                    @foreach($sosyals as $sosyal)
                        @if($config->$sosyal!=null)
                        <li class="list-inline-item">
                            <a href="{{$config->$sosyal}}" target="_blank">
                            <span class="fa-stack fa-lg">
                              <i class="fas fa-circle fa-stack-2x"></i>
                              <i class="fab fa-{{$sosyal}} fa-stack-1x fa-inverse"></i>
                            </span>
                            </a>
                        </li>
                        @endif
                    @endforeach

                </ul>
                <p class="copyright text-muted">Copyright &copy; {{date('Y') .' - '. $config->title}}</p>
            </div>
        </div>
    </div>
</footer>

<!-- Bootstrap core JavaScript -->
<script src="{{asset('front/')}}/vendor/jquery/jquery.min.js"></script>
<script src="{{asset('front/')}}/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- Custom scripts for this template -->
<script src="{{asset('front/')}}/js/clean-blog.min.js"></script>

</body>

</html>
