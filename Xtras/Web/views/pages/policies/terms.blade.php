@extends('layouts.master')

@section('title')
	Terms of Service
@stop

@section('content')
	<h1>Terms of Service</h1>

	<div class="visible-xs visible-sm"></div>

	<div class="visible-md visible-lg">
		<div class="btn-toolbar">
			<div class="btn-group">
				<a href="{{ URL::route('policies') }}" class="btn btn-default">{{ $_icons['back'] }}</a>
			</div>
		</div>
	</div>

	<p>By using the AnodyneXtras web site ("Service"), or any services of Anodyne Productions ("Anodyne"), you are agreeing to be bound by the following terms and conditions ("Terms of Service"). IF YOU ARE ENTERING INTO THIS AGREEMENT ON BEHALF OF A COMPANY OR OTHER LEGAL ENTITY, YOU REPRESENT THAT YOU HAVE THE AUTHORITY TO BIND SUCH ENTITY, ITS AFFILIATES AND ALL USERS WHO ACCESS OUR SERVICES THROUGH YOUR ACCOUNT TO THESE TERMS AND CONDITIONS, IN WHICH CASE THE TERMS "YOU" OR "YOUR" SHALL REFER TO SUCH ENTITY, ITS AFFILIATES AND USERS ASSOCIATED WITH IT. IF YOU DO NOT HAVE SUCH AUTHORITY, OR IF YOU DO NOT AGREE WITH THESE TERMS AND CONDITIONS, YOU MUST NOT ACCEPT THIS AGREEMENT AND MAY NOT USE THE SERVICES.</p>

	<p>If Anodyne makes material changes to these Terms, we will notify you by email or by posting a notice on our site before the changes are effective. Any new features that augment or enhance the current Service, including the release of new tools and resources, shall be subject to the Terms of Service. Continued use of the Service after any such changes shall constitute your consent to such changes. You can review the most current version of the Terms of Service at any time at: <a href="{{ URL::route('policies', ['terms']) }}">http://xtras.anodyne-productions.com/policies/terms</a>.</p>

	<p>Violation of any of the terms below will result in the termination of your Account. While Anodyne prohibits such conduct and Content on the Service, you understand and agree that Anodyne cannot be responsible for the Content posted on the Service and you nonetheless may be exposed to such materials. You agree to use the Service at your own risk.</p>

	<h2>Account Terms</h2>

	<ul>
		<li>You must be 13 years or older to use this Service.</li>

		<li>You must be a human. Accounts registered by "bots" or other automated methods are not permitted.</li>

		<li>You must provide your name, a valid email address, and any other information requested in order to complete the signup process.</li>

		<li>You are responsible for maintaining the security of your account and password. Anodyne cannot and will not be liable for any loss or damage from your failure to comply with this security obligation.</li>

		<li>You are responsible for all Content posted and activity that occurs under your account.</li>

		<li>You may not use the Service for any illegal or unauthorized purpose. You must not, in the use of the Service, violate any laws in your jurisdiction (including but not limited to copyright or trademark laws).</li>
	</ul>

	<h2>Copyright and Content Ownership</h2>

	<ul>
		<li>We claim no intellectual property rights over the material you provide to the Service. Your profile and materials uploaded remain yours. However, by uploading your Content, you agree to allow others to view your Content.</li>

		<li>We do not pre-screen Content, but it is our sole discretion to refuse or remove any Content that is available via the Service.</li>

		<li>The look and feel of the Service is copyright &copy;2014 Anodyne Productions All rights reserved. You may not duplicate, copy, or reuse any portion of the HTML/CSS, Javascript, or visual design elements or concepts without express written permission from Anodyne.</li>
	</ul>

	<h2>General Conditions</h2>

	<ul>
		<li>Your use of the Service is at your sole risk. The service is provided on an "as is" and "as available" basis.</li>

		<li>Support for Anodyne services is only available in English.</li>

		<li>You understand that Anodyne uses third party vendors and hosting partners to provide the necessary hardware, software, networking, storage, and related technology required to run the Service.</li>

		<li>You must not modify, adapt or hack the Service or modify another website so as to falsely imply that it is associated with the Service, Anodyne, or any other Anodyne service or product.</li>

		<li>You agree not to reproduce, duplicate, copy, sell, resell or exploit any portion of the Service, use of the Service, or access to the Service without the express written permission by Anodyne.</li>

		<li>We may, but have no obligation to, remove Content and Accounts containing Content that we determine in our sole discretion are unlawful, offensive, threatening, libelous, defamatory, pornographic, obscene or otherwise objectionable or violates any party's intellectual property or these Terms of Service.</li>

		<li>Verbal, physical, written or other abuse (including threats of abuse or retribution) of any Anodyne customer, employee, member, or officer will result in immediate account termination.</li>

		<li>You understand that the technical processing and transmission of the Service, including your Content, may be transferred unencrypted and involve (a) transmissions over various networks; and (b) changes to conform and adapt to technical requirements of connecting networks or devices.</li>

		<li>You must not upload, post, host, or transmit unsolicited email, SMSs, or "spam" messages.</li>

		<li>You must not transmit any worms or viruses or any code of a destructive nature.</li>

		<li>If your use of available space exceeds the average space usage (as determined solely by Anodyne) of other Service customers, we reserve the right to immediately disable your account or suspend your ability to upload until you can reduce your space consumption.</li>

		<li>Anodyne does not warrant that (i) the service will meet your specific requirements, (ii) the service will be uninterrupted, timely, secure, or error-free, (iii) the results that may be obtained from the use of the service will be accurate or reliable, (iv) the quality of any products, services, information, or other material purchased or obtained by you through the service will meet your expectations, and (v) any errors in the Service will be corrected.</li>

		<li>You expressly understand and agree that Anodyne shall not be liable for any direct, indirect, incidental, special, consequential or exemplary damages, including but not limited to, damages for loss of profits, goodwill, use, data or other intangible losses (even if Anodyne has been advised of the possibility of such damages), resulting from: (i) the use or the inability to use the service; (ii) the cost of procurement of substitute goods and services resulting from any goods, data, information or services purchased or obtained or messages received or transactions entered into through or from the service; (iii) unauthorized access to or alteration of your transmissions or data; (iv) statements or conduct of any third party on the service; (v) or any other matter relating to the service.</li>

		<li>The failure of Anodyne to exercise or enforce any right or provision of the Terms of Service shall not constitute a waiver of such right or provision. The Terms of Service constitutes the entire agreement between you and Anodyne and govern your use of the Service, superseding any prior agreements between you and Anodyne (including, but not limited to, any prior versions of the Terms of Service). You agree that these Terms of Service and Your use of the Service are governed under New York law.</li>

		<li>Questions about the Terms of Service should be sent to admin@anodyne-productions.com.</li>
	</ul>
@stop