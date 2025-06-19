@extends('layouts.layout')
@section('styles')
   {{-- <link rel="stylesheet" href="{{ asset('admin/css/styles.css') }}" /> --}}
   <link rel="stylesheet" href="{{ asset('frontend/assets/css/help.css') }}">
@endsection
@section('content')

<main>
		<div class="hero_single inner_pages help-page">
			<div class="opacity-mask" data-opacity-mask="rgba(0, 0, 0, 0.7)">
				<div class="container">
					<div class="row justify-content-center">
						<div class="col-xl-8 col-lg-10 col-md-8">
							<h1>Help and support</h1>
							<p>Search questions or useful articles</p>
							<form action="{{ route('help.index') }}" method="GET">
							<div class="search_bar">
								<input type="text" name="search" class="form-control" placeholder="What are you looking for?" value="{{ request('search') }}">
								<input type="submit" value="Search">
							</div>
						    </form>
						</div>
					</div>
					<!-- /row -->
				</div>
			</div>
		</div>
		<!-- /hero_single -->

		<div class="bg_gray">
			<div class="container margin_60_40">
				<div class="main_title center">
				    <span><em></em></span>
				    <h2>Select a topic</h2>
				    <p>Choose a category below to get the information or assistance you need quickly and easily.</p>
				</div>

				<div class="row">
					@foreach(App\Models\Help::CATEGORIES as $category)
					<div class="col-lg-4 col-md-6">
						<a class="box_topic" href="{{ route('help.index', ['category' => $category]) }}">
							<span>
								@switch($category)
									@case('Payment')
										<i class="icon_wallet"></i>
										@break
									@case('Registration')
										<i class="icon_cloud-upload_alt"></i>
										@break
									@case('General')
										<i class="icon_lifesaver"></i>
										@break
									@case('Event')
										<i class="icon_globe-2"></i>
										@break
									@case('Cancellation')
										<i class="icon_close_alt2"></i>
										@break
									@case('Reviews')
										<i class="icon_star"></i>
										@break
									@default
										<i class="icon_documents_alt"></i>
								@endswitch
							</span>
							<h3>{{ $category }}</h3>
							<p>{{ $helps->where('category', $category)->count() }} articles available</p>
						</a>
					</div>
					@endforeach
				</div>

			</div>
			<!-- /container -->
		</div>
		<!-- /bg_gray -->
		<div class="container margin_60_40">
				<div class="main_title version_2">
					<span><em></em></span>
					<h2>{{ request('category') ? request('category') . ' FAQs' : 'All FAQs' }}</h2>
					<p>Find answers to your questions about {{ request('category') ? strtolower(request('category')) : 'our services' }}</p>
				</div>
				@if($helps->isEmpty())
					<div class="alert alert-info">
						No FAQs found {{ request('search') ? 'for "' . request('search') . '"' : '' }}.
					</div>
				@else
					<div class="list_articles add_bottom_25 clearfix">
						<ul>
							@foreach($helps as $help)
							<li>
								<a href="#faq-{{ $help->id }}" class="faq-toggle" data-faq-id="faq-{{ $help->id }}">
									<i class="icon_documents_alt"></i>{{ $help->question }}
								</a>
								<div class="collapse" id="faq-{{ $help->id }}">
									<div class="card card-body">
										{!! nl2br(e($help->answer)) !!}
									</div>
								</div>
							</li>
							@endforeach
						</ul>
					</div>
				@endif
		</div>
			<!-- /container -->
	</main>

<style>
.faq-question:hover { background: #f0f4ff; }
.faq-item.active .faq-question { background: #e8f0fe; }
.faq-answer { transition: all 0.2s; }
</style>
<script>
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.faq-toggle').forEach(function(q) {
        q.addEventListener('click', function(e) {
            e.preventDefault();
            var faqId = this.getAttribute('data-faq-id');
            var answer = document.getElementById(faqId);
            if (answer.classList.contains('show')) {
                answer.classList.remove('show');
            } else {
                answer.classList.add('show');
            }
        });
    });
});
</script>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Handle search form submission
    const searchForm = document.querySelector('form');
    const searchInput = searchForm.querySelector('input[name="search"]');
    
    searchForm.addEventListener('submit', function(e) {
        if (!searchInput.value.trim()) {
            e.preventDefault();
        }
    });

    // Handle category links
    const categoryLinks = document.querySelectorAll('.box_topic');
    categoryLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            const currentCategory = new URLSearchParams(window.location.search).get('category');
            const newCategory = this.getAttribute('href').split('category=')[1];
            
            if (currentCategory === newCategory) {
                e.preventDefault();
                window.location.href = "{{ route('help.index') }}";
            }
        });
    });
});
</script>
@endpush

@endsection