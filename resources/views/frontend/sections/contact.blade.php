@extends('layouts.layout')
@section('styles')
   {{-- <link rel="stylesheet" href="{{ asset('admin/css/styles.css') }}" /> --}}
@endsection
@section('content')

<main>
    @foreach ($contactbanners as $banner)
    <div class="hero_single inner_pages contact-page" style="background: url('{{ asset($banner->banner_image) }}') center center/cover no-repeat;">

        <div class="opacity-mask" data-opacity-mask="rgba(0, 0, 0, 0.6)">
            <div class="container">
                
                <div class="row justify-content-center">
                    <div class="col-xl-9 col-lg-10 col-md-8">
                        <h1>{{ $banner->heading }}</h1>
                        <p>{{ $banner->sub_heading }}</p>
                    </div>
                </div>
               
                <!-- /row -->
            </div>
        </div>
    </div>
    @endforeach
    <!-- /hero_single -->

    <div class="bg_gray">
        <div class="container margin_60_40">
            @foreach($contactdetails as $detail)
            <div class="row justify-content-center">
                <div class="col-lg-4">
                    <div class="box_contacts">
                        <i class="{{ $detail->icon1 }}"></i>
                        <h2>{{ $detail->heading1 }}</h2>
                        <a href="#0">{{ $detail->sub_heading1 }}</a>
                        <small>{{ $detail->description1 }}</small>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="box_contacts">
                        <i class="{{ $detail->icon2 }}"></i>
                        <h2>{{ $detail->heading2 }}</h2>
                        <div>{{ $detail->sub_heading2 }}</div>
                        <small>{{ $detail->description2 }}</small>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="box_contacts">
                        <i class="{{ $detail->icon3 }}"></i>
                        <h2>{{ $detail->heading3 }}</h2>
                        <a href="#0">{{ $detail->sub_heading3 }}</a>
                        <small>{{ $detail->description3 }}</small>
                    </div>
                </div>
            </div>
            <!-- /row -->
            @endforeach
        </div>
        <!-- /container -->
    </div>
    <!-- /bg_gray -->

    <div class="container margin_60_40">
        <h5 class="mb_5">Drop Us a Line</h5>
        <div class="row">
            <div class="col-lg-4 col-md-6 add_bottom_25">
                <div id="message-contact"></div>
                <form>
                    <div class="form-group">
                        <input class="form-control" type="text" placeholder="Name" id="name_contact" name="name_contact">
                    </div>
                    <div class="form-group">
                        <input class="form-control" type="email" placeholder="Email" id="email_contact" name="email_contact">
                    </div>
                    <div class="form-group">
                        <textarea class="form-control" style="height: 150px;" placeholder="Message" id="message_contact" name="message_contact"></textarea>
                    </div>
                    <div class="form-group">
                        <input class="form-control" type="text" id="verify_contact" name="verify_contact" placeholder="Are you human? 3 + 1 =">
                    </div>
                    <div class="form-group">
                        <input class="btn_1 full-width" type="submit" value="Submit" id="submit-contact">
                    </div>
                </form>
            </div>
            <div class="col-lg-8 col-md-6 add_bottom_25">
             <iframe class="map_contact" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d117925.2168964497!2d88.26495015954832!3d22.535564937570197!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x39f882db4908f667%3A0x43e330e68f6c2cbc!2sKolkata%2C%20West%20Bengal!5e0!3m2!1sen!2sin!4v1729928348060!5m2!1sen!2sin" allowfullscreen></iframe>
                
            </div>
        </div>
    </div>
    <!-- /container -->

</main>

@endsection