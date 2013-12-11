@extends('layouts.master')

@section('title')
	Item
@stop

@section('content')
	<div class="row">
		<div class="col-sm-9 col-lg-9">
			<h1>Pulsar</h1>

			<div>
				<span class="label label-success">Nova 1</span>
				<span class="label label-success">Nova 2</span>
				<span class="label">Nova 3</span>
			</div>

			<p>AnodyneXtras is the one-stop-shop to find skins, MODs and rank sets created by Anodyne Productions and the wider Anodyne community. From here you can search for and download items to make your Nova sim more unique.</p>

			<ul class="nav nav-tabs">
				<li class="active"><a href="#basic" data-toggle="tab">Basic Info</a></li>
				<li><a href="#instructions" data-toggle="tab">Instructions</a></li>
				<li><a href="#downloads" data-toggle="tab">Downloads</a></li>
				<li><a href="#history" data-toggle="tab">History</a></li>
				<li><a href="#comments" data-toggle="tab">Comments <span class="label">21</span></a></li>
			</ul>

			<div class="tab-content">
				<div id="basic" class="active tab-pane"></div>

				<div id="instructions" class="tab-pane"></div>

				<div id="downloads" class="tab-pane">
					<div class="data-table data-table-bordered data-table-striiped">
						<div class="row">
							<div class="col-lg-8">
								<p class="lead">Pulsar for Nova 2</p>
							</div>

							<div class="col-lg-2">
								<p class="lead text-muted">2.2.6</p>
							</div>

							<div class="col-lg-2">
								<div class="btn-toolbar pull-right">
									<div class="btn-group">
										<a href="#" class="btn btn-default btn-small icn-size-16"><span class="icn" data-icon="s"></span></a>
									</div>

									<div class="btn-group">
										<a href="#" class="btn btn-primary btn-small icn-size-16"><span class="icn" data-icon="d"></span></a>
									</div>
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-lg-8">
								<p class="lead">Pulsar for Nova 2</p>
							</div>

							<div class="col-lg-2">
								<p class="lead text-muted">2.1.12</p>
							</div>

							<div class="col-lg-2">
								<div class="btn-toolbar pull-right">
									<div class="btn-group">
										<a href="#" class="btn btn-default btn-small icn-size-16"><span class="icn" data-icon="s"></span></a>
									</div>

									<div class="btn-group">
										<a href="#" class="btn btn-primary btn-small icn-size-16"><span class="icn" data-icon="d"></span></a>
									</div>
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-lg-8">
								<p class="lead">Pulsar for Nova 1</p>
							</div>

							<div class="col-lg-2">
								<p class="lead text-muted">1.3.2</p>
							</div>

							<div class="col-lg-2">
								<div class="btn-toolbar pull-right">
									<div class="btn-group">
										<a href="#" class="btn btn-default btn-small icn-size-16"><span class="icn" data-icon="s"></span></a>
									</div>

									<div class="btn-group">
										<a href="#" class="btn btn-primary btn-small icn-size-16"><span class="icn" data-icon="d"></span></a>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="col-sm-3 col-lg-3">
			<div class="row">
				<div class="col-lg-12"><img class="img-rounded" src="http://placehold.it/260x175"></div>
			</div>

			<hr>

			<div>
				<a href="#" class="btn btn-small btn-default btn-block">More by this author</a>
				<a href="#" class="btn btn-small btn-default btn-block">Report issue to the author</a>
				<a href="#" class="btn btn-small btn-default btn-block">Report issue to Anodyne</a>
			</div>

			<dl>
				<dt>Author</dt>
				<dd>Anodyne Productions</dd>

				<dt>Submitted</dt>
				<dd>{{ Date::now()->format('d F Y') }}</dd>

				<dt>Downloads</dt>
				<dd>500</dd>

				<dt>Rating</dt>
				<dd>4.2</dd>
			</dl>
		</div>
	</div>
@stop