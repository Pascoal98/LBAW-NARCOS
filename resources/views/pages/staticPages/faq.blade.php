@extends('layouts.app')

@section('title', "- FAQ")

@section('content')

    <div class="container text-center my-5 p-5 bg-secondary" id="faqContainer">
        <h1>FAQ</h1>
        <p>
            Here, you can find answers to questions that you may have:
        </p>

        <div class="accordion text-center" id="faqAccordion">
            <div class="accordion-item my-5">
                <h4 class="accordion-header " id="headingOne">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                        How do I authenticate?
                    </button>
                </h4>
                <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                        On the top right corner of website, there are 2 buttons wich you can use to either login or register. If you are
                        already signed in, a logout button will be shown instead in case you want to logout.
                    </div>
                </div>
            </div>

            <div class="accordion-item my-5">
                <h4 class="accordion-header " id="headingFour">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                        What happens if I break the rules?
                    </button>
                </h4>
                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                        We expect people to follow rules in order to have a friendly environment. This way, if you break them, administrators
                        can suspend you and will not have access to your account for some time
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
