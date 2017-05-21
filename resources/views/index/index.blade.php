@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Browse Ideas
                <small>111 ideas</small>
            </h1>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <h3>Project One</h3>
            <h4>Subheading</h4>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Laudantium veniam exercitationem expedita laborum at voluptate. Labore, voluptates totam at aut nemo deserunt rem magni pariatur quos perspiciatis atque eveniet unde.</p>
            <a class="btn btn-primary" href="#">View Project</a>
        </div>
    </div>
    <hr>

    <!-- Pagination -->
    <div class="row text-center">
        <div class="col-lg-12">
            <ul class="pagination">
                <li>
                    <a href="#">&laquo;</a>
                </li>
                <li class="active">
                    <a href="#">1</a>
                </li>
                <li>
                    <a href="#">2</a>
                </li>
                <li>
                    <a href="#">3</a>
                </li>
                <li>
                    <a href="#">4</a>
                </li>
                <li>
                    <a href="#">5</a>
                </li>
                <li>
                    <a href="#">&raquo;</a>
                </li>
            </ul>
        </div>
    </div>
    <!-- /.row -->
</div>
@endsection
