@extends('layouts.master')

@section('title')
	Markdown Guide
@stop

@section('content')
	<h1>{{ $_icons['markdown-lg'] }} Markdown Guide</h1>

	<p>Markdown is a plain-text formatting syntax designed to be converted into HTML. Markdown is popularly used to format readme files, for writing messages in online discussion forums or in text editors for the quick creation of rich text documents.</p>

	<hr class="partial-split">

	<h2>Typography</h2>

	<div class="row">
		<div class="col-md-6">
			<pre># Primary Heading

## Secondary Heading

### Tertiary Heading

_Italicized text_
*Italicized text*

__Bolded text__
**Bolded text**

`Code block`</pre>
		</div>
		<div class="col-md-6">
			{{ Markdown::parse("# Primary Heading") }}
			{{ Markdown::parse("## Secondary Heading") }}
			{{ Markdown::parse("### Tertiary Heading") }}

			{{ Markdown::parse("_Italicized text_") }}
			{{ Markdown::parse("*Italicized text*") }}

			{{ Markdown::parse("__Bolded text__") }}
			{{ Markdown::parse("**Bolded text**") }}

			{{ Markdown::parse("`Code block`") }}
		</div>
	</div>

	<hr class="partial-split">

	<h2>Links</h2>

	<div class="row">
		<div class="col-md-6">
			<pre>[Google](http://google.com)

[Local link](skins)</pre>
		</div>
		<div class="col-md-6">
			{{ Markdown::parse("[Google](http://google.com)") }}

			{{ Markdown::parse("[Local link](skins)") }}
		</div>
	</div>

	<hr class="partial-split">

	<h2>Unordered Lists</h2>

	<div class="row">
		<div class="col-md-6">
			<pre>- Unordered Item #1
- Unordered Item #2
- Unordered Item #3
- Unordered Item #4

* Another list 1
* Another list 2
* Another list 3

+ A final list 1
+ A final list 2
+ A final list 3</pre>

			<p class="alert alert-info">Unordered lists can use hyphens (-), asterisks (*), or pluses (+) for the individual items.</p>
		</div>
		<div class="col-md-6">
			{{ Markdown::parse("- Unordered Item #1
- Unordered Item #2
- Unordered Item #3
- Unordered Item #4") }}

			{{ Markdown::parse("* Another list 1
* Another list 2
* Another list 3") }}

			{{ Markdown::parse("+ A final list 1
+ A final list 2
+ A final list 3") }}
		</div>
	</div>

	<hr class="partial-split">

	<h2>Ordered Lists</h2>

	<div class="row">
		<div class="col-md-6">
			<pre>1. Ordered Item 1
2. Ordered Item 2
3. Ordered Item 3
4. Ordered Item 4

1. Another ordered Item 1
112. Another ordered Item 2
4534. Another ordered Item 3
2. Another ordered Item 4</pre>

			<p class="alert alert-info">The numbers you use in ordered lists do not matter. They do not have to be sequential or even different numbers.</p>
		</div>
		<div class="col-md-6">
			{{ Markdown::parse("1. Ordered Item 1
2. Ordered Item 2
3. Ordered Item 3
4. Ordered Item 4") }}

			{{ Markdown::parse("1. Another ordered Item 1
112. Another ordered Item 2
2. Another ordered Item 3
87823. Another ordered Item 4") }}
		</div>
	</div>
@stop