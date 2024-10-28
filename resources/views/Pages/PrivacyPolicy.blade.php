@extends('TemplateLayout.UserLayout')

@push('title')
    <title>QRUN Website - Privacy Policy</title>
@endpush

@section('content')
    <div class="container-fluid overflow-x-hidden">
        <!-- Page Heading -->
        <!-- DataTales Example -->
        <div class="card shadow mb-4 mt-4" style="overflow-x: scroll">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary" style="color: black !important;">Privacy Policy</h6>
            </div>
            <div class="card-body m-2" style="overflow-x: scroll !important;color: black !important;">
                <h3 style="font-weight: bold">Acceptance of Terms</h3>
                <p>By accessing and using this website, you agree to be bound by the terms and conditions stated in this
                    document. If you do not agree to these terms, please do not use our services.
                </p>
                <h3 style="font-weight: bold">Introduction</h3>
                <p>
                    This policy explains how we collect, use and protect your personal information when you use this website. By using our site, you agree to the collection and use of information in accordance with this policy.
                </p>
                <h3 style="font-weight: bold">Information We Collect</h3>

                <p  style="font-weight: bold">2.1 Personal Data</p>
                <p>When you register or login using your Google account or manual registering, we may collect personal information such as:
                </p>
                <ul>
                    <li>Name</li>
                    <li>Email</li>
                    <li>Phone</li>
                    <li>Address</li>
                </ul>
                <p  style="font-weight: bold">2.2 Non Personal Data</p>
                <p>We may also collect non-personal information such as:
                </p>
                <ul>
                    <li>IP Address</li>
                    <li>Browser Type</li>
                    <li>Pages you visit on our site</li>
                    <li>Time and date of access</li>
                </ul>
                <h3 style="font-weight: bold">Use of Information</h3>
                {{-- <p style="font-weight: bold">4.1 Content Responsibility</p> --}}
                <p>We use the information we collect to:
                </p>
                <ul>
                    <li>Facilitate registration and login</li>
                    <li>Improve user experience</li>
                    <li>Send service-related updates and information</li>
                    <li>Analyze site usage to improve our services</li>
                </ul>
                <h3 style="font-weight: bold">Hosting and Data Security</h3>
                {{-- <p style="font-weight: bold">4.1 Content Responsibility</p> --}}
                <p>Our site is hosted using cPanel, which provides tools and features to help manage the security of your data. We take reasonable security measures to protect your personal information from unauthorized access, use, or disclosure. However, no method of transmission over the internet or method of electronic storage is 100% secure.
                </p>

                <h3 style="font-weight: bold">Disclosure to Third Parties</h3>
                <p>We do not sell, trade, or otherwise transfer your personal information to third parties without your permission, except as required by law or to protect our rights.
                </p>
                <h3 style="font-weight: bold">User Rights</h3>
                <p>You have the right to:
                </p>
                <ul>
                    <li>Access your personal information in our possession</li>
                    <li>Correct inaccurate information</li>
                    <li>Delete your personal information in accordance with applicable provisions</li>
                </ul>
                
                <h3 style="font-weight: bold">Policy Updates</h3>
                <p>We may update this privacy policy from time to time. Changes will be notified through our website. You are advised to review this policy periodically.</p>
                <p>This policy is effective as of 2024-09-09</p>

                <h3 style="font-weight: bold">Contact Us</h3>
                <p>If you have any questions or suggestions about our Privacy Policy, do not hesitate to contact us
                    at
                    support@qrun.online</p>
            </div>

        </div>

    </div>
@endsection
