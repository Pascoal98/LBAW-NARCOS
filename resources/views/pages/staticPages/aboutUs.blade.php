@extends('layouts.app')

@section('title', "- About Us")

@section('content')

    <div class="container text-center my-5 p-5 bg-secondary">
        <h1>About us</h1>
        <div class="horizontalDivider mb-5"></div>

        <p>
            We are in an era of technology growth, but with it, the amount of wrong information on the internet and
            media algo grows. The constant interactions between users and the feedback provided by them, maintain the 
            integrity of the information shared, in a friendly and accessible space.
        </p>

        <p>
            Let's learn with eachother!!!!!
        </p>

        <p>
            If you need help, don't mind bothering one of the following:
        </p>
        
        <div class="row py-3" id="contactsSection">
            
            <div class="col mb-3 d-flex justify-content-center">
                <div class="card">
                    <img class="card-img-top" src="storage/up201806860.jpg" alt="André Leonor">
                    <div class="card-body">
                        <h4>André Leonor</h4>
                        <a href="https://sigarra.up.pt/feup/pt/fest_geral.cursos_list?pv_num_unico=201806860"></a>
                    </div>
                </div>
            </div>

            <div class="col mb-3 d-flex justify-content-center">
                <div class="card">
                    <img class="card-img-top" src="storage/up201705562.jpg" alt="Bruno Pascoal">
                    <div class="card-body">
                        <h4>Bruno Pascoal</h4>
                        <a href="https://sigarra.up.pt/feup/pt/fest_geral.cursos_list?pv_num_unico=201705562"></a>
                    </div>
                </div>
            </div>

            <div class="col mb-3 d-flex justify-content-center">
                <div class="card">
                    <img class="card-img-top" src="storage/up201910223.jpg" alt="Fernando Barros">
                    <div class="card-body">
                        <h4>Fernando Barros</h4>
                        <a href="https://sigarra.up.pt/feup/pt/fest_geral.cursos_list?pv_num_unico=201705562"></a>
                    </div>
                </div>
            </div>

            <div class="col mb-3 d-flex justify-content-center">
                <div class="card">
                    <img class="card-img-top" src="storage/up201105191.jpg" alt="Miguel Curval">
                    <div class="card-body">
                        <h4>Miguel Curval</h4>
                        <a href="https://sigarra.up.pt/feup/pt/fest_geral.cursos_list?pv_num_unico=201105191"></a>
                    </div>
                </div>
            </div>

        </div>

    </div>

@endsection
