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
                    How do I create authenticate?
                </h4>
                <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                        On the top right corner of website, there are 2 buttons wich you can use to either sign in or sign up. If you are
                        already signed in, a logout button will be shown instead in case you ant to do so
                    </div>
                </div>
            </div>

            <div class="accordion-item my-5">
                <h4 class="accordion-header " id="headingFour">
                    What happens if I break the rules?
                </h4>
                <div id="collapseFour" class="collapse" aria-labelledby="headingFour" data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                        We expect people to follow rules in order to have a friendly environment. This way, if you break them, administrators
                        can suspend you and will not have access to your account for some time
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
