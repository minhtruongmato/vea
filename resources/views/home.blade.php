@extends('layouts.client')

@section('page_title')
    Homepage
@endsection

@section('view')
    <div id="homepage">
        <!-- SECTION SLIDER -->
        <div class="section section-slider">
            <div class="mask" style="width: 100%; height: 100%">
                <img src="https://images.unsplash.com/photo-1584575449242-3f2809cb7570?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=800&q=60" alt="image">
            </div>
        </div>

        <!-- SECTION ABOUT -->
        <div class="section section-about">
            <div class="container">
                <div class="row about-desc">
                    <div class="section-heading col-md-7 col-sm-12">
                        <h6 class="subtitle-md">About us</h6>
                        <h3>Aenean rhoncus, nibh a elementum imperdiet</h3>
                    </div>

                    <div class="section-desc col-md-5 col-sm-12">
                        <p>Nullam sed laoreet quam. Proin ultricies sed turpis a tincidunt. Suspendisse turpis lacus, ultricies eu auctor condimentum, semper quis arcu. Phasellus ultrices hendrerit libero, a sollicitudin purus vulputate a. Nunc et lectus ut lacus vestibulum egestas id vitae tellus. Proin lectus tortor, cursus tincidunt ipsum id, mollis ullamcorper arcu. Phasellus tortor lacus, commodo ut euismod vitae, accumsan id dui. Quisque euismod felis quis pharetra venenatis. </p>
                    </div>
                </div>

                <div class="row about-subjects">
                    @for($i=0;$i<3;$i++)
                        <div class="item col-md-2 col-sm-12">
                            <div class="inner">
                                <a href="#">
                                    <h6>
                                        Job #{{ $i + 1 }}
                                    </h6>

                                    <i class="fas fa-home"></i>
                                </a>
                            </div>
                        </div>
                    @endfor
                </div>
            </div>
        </div>
    </div>
@endsection