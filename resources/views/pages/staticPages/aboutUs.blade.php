@extends('layouts.app')

@section('title', "- About Us")

@section('content')

    <div class="container text-center my-5 p-5 bg-secondary">
        <h1>About us</h1>
        <div class="horizontalDivider mb-5"></div>
        <p>
            FEUP students doing the LBAW project together!
        <p>
        
        <div class="row py-3" id="contactsSection">
            
            <div class="col mb-3 d-flex justify-content-center">
                <div class="card">
                    <img class="card-img-top" src="storage/up201806860.jpg" alt="André Leonor">
                    <div class="card-body">
                        <h4>André Leonor</h4>
                        <a href="">up201806860@up.pt</a>
                    </div>
                </div>
            </div>

            <div class="col mb-3 d-flex justify-content-center">
                <div class="card">
                    <img class="card-img-top" src="storage/up201705562.jpg" alt="Bruno Pascoal">
                    <div class="card-body">
                        <h4>Bruno Pascoal</h4>
                        <a href="">up201705562@up.pt</a>
                    </div>
                </div>
            </div>

            <div class="col mb-3 d-flex justify-content-center">
                <div class="card">
                    <img class="card-img-top" src="storage/up201910223.jpg" alt="Fernando Barros">
                    <div class="card-body">
                        <h4>Fernando Barros</h4>
                        <a href="">up201910223@up.pt</a>
                    </div>
                </div>
            </div>

            <div class="col mb-3 d-flex justify-content-center">
                <div class="card">
                    <img class="card-img-top" src="storage/up201105191.jpg" alt="Miguel Curval">
                    <div class="card-body">
                        <h4>Miguel Curval</h4>
                        <a href="">up201105191@up.pt</a>
                    </div>
                </div>
            </div>

        </div>

    </div>

@endsection
