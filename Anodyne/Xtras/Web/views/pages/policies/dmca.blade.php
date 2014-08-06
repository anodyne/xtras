@extends('layouts.master')

@section('title')
	DMCA Takedown Policy
@stop

@section('content')
	<h1>DMCA Takedown Policy</h1>

	<div class="visible-xs visible-sm"></div>

	<div class="visible-md visible-lg">
		<div class="btn-toolbar">
			<div class="btn-group">
				<a href="{{ URL::route('policies') }}" class="btn btn-default">{{ $_icons['back'] }}</a>
			</div>
		</div>
	</div>

	<p>Anodyne Productions ("Anodyne") supports the protection of intellectual property and asks the users of its services to do the same. It is the policy of Anodyne to respond to all notices of alleged copyright infringement.</p>

	<p>Notice is specifically given that Anodyne is not responsible for the content on other websites that any user may find or access when using any Anodyne services. This notice describes the information that should be provided in notices alleging copyright infringement found specifically on anodyne-productions.com, and this notice is designed to make alleged infringement notices to Anodyne as straightforward as possible and, at the same time, minimize the number of notices that Anodyne receives that are spurious or difficult to verify. The form of notice set forth below is consistent with the form suggested by the United States Digital Millennium Copyright Act ("DMCA") which may be found at the U.S. Copyright official website: <a href="http://www.copyright.gov" target="_blank">http://www.copyright.gov</a>.</p>

	<p>It is the policy of Anodyne, in appropriate circumstances and in its sole discretion, to disable and/or terminate the accounts of users of Anodyne users who may infringe upon the copyrights or other intellectual property rights of Anodyne and/or others.</p>

	<p>Our response to a notice of alleged copyright infringement may result in removing or disabling access to material claimed to be a copyright infringement and/or termination of the subscriber. If Anodyne removes or disables access in response to such a notice, we will make a reasonable effort to contact the responsible party of our decision so that they may make an appropriate response.</p>

	<p>To file a notice of an alleged copyright infringement with us, you are required to provide a written communication only by email. Notice is also given that you may be liable for damages (including costs and attorney fees) if you materially misrepresent that a product or activity is infringing upon your copyright.</p>

	<h2>Copyright Claims</h2>

	<p>To expedite our handling of your notice, please use the following format or refer to Section 512(c)(3) of the Copyright Act.</p>

	<ol>
		<li>Identify the copyrighted work you believe has been infringed. The specificity of your identification may depend on the nature of the work you believe has been infringed, but may include things like a link to a web page or a specific post (as opposed to a link to a general site URL).</li>

		<li>Identify the material that you allege is infringing upon the copyrighted work listed in Item #1 above. This identification needs to be reasonably sufficient to permit Anodyne to locate the material. In other words, please include the URL to the material allegedly infringing your copyright (URL of a website or URL to a post, with title, date, name of the emitter), or link to an initial post with sufficient data to find it.</li>

		<li>Provide information on which Anodyne may contact you, including your email address, name, telephone number and physical address.</li>

		<li>Provide the address, if available, to allow Anodyne to notify the owner/administrator of the allegedly infringing webpage or other content, including email address.</li>

		<li>Also include a statement of the following: "I have a good faith belief that use of the copyrighted materials described above on the infringing web pages is not authorized by the copyright owner, or its agent, or the law."</li>

		<li>Also include the following statement: "I swear, under penalty of perjury, that the information in this notification is accurate and that I am the copyright owner, or am authorized to act on behalf of the owner, of an exclusive right that is allegedly infringed."</li>

		<li>Your physical or electronic signature.</li>
	</ol>

	<p>Send email notification to admin@anodyne-productions.com.</p>

	<h2>Counter-Notification Policy</h2>

	<p>To be effective, a Counter-Notification must be a written communication by the alleged infringer provided to Anodyne's Designated Agent (as set forth above) that includes substantially the following:</p>

	<ol>
		<li>A physical or electronic signature of the Subscriber;</li>

		<li>Identification of the material that has been removed or to which access has been disabled and the location at which the material appeared before it was removed or access to it was disabled;</li>

		<li>A statement under penalty of perjury that the Subscriber has a good faith belief that the material was removed or disabled as a result of a mistake or misidentification of the material to be removed or disabled;</li>

		<li>The Subscriber's name, address, and telephone number, and a statement that the Subscriber consents to the jurisdiction of Federal District Court for the judicial district of New York, or if the Subscriber's address is outside of the United States, for any judicial district in which Anodyne may be found, and that the Subscriber will accept service of process from the person who provided notification or an agent of such person.</li>
	</ol>

	<p>Upon receipt of a Counter Notification containing the information as outlined in 1 through 4 above:</p>

	<ul>
		<li>Anodyne shall promptly provide the Complaining Party with a copy of the Counter Notification;</li>

		<li>Anodyne shall inform the Complaining Party that it will replace the removed material or cease disabling access to it within ten (10) business days;</li>

		<li>Anodyne shall replace the removed material or cease disabling access to the material within ten (10) to fourteen (14) business days following receipt of the Counter Notification, provided Anodyne's Designated Agent has not received notice from the Complaining Party that an action has been filed seeking a court order to restrain Subscriber from engaging in infringing activity relating to the material on Anodyne's system.</li>
	</ul>

	<p>Finally Notices and Counter-Notices with respect to this website must meet then current statutory requirements imposed by the DMCA; see <a href="http://www.copyright.gov" target="_blank">http://www.copyright.gov</a> for details. If you need help filing or creating a Counter-Notice, there are plenty of resources online. <a href="http://www.chillingeffects.org/dmca/counter512.pdf" target="_blank">Chilling Effect's Counter-Notice Generator</a> is one good resource.</p>
@stop