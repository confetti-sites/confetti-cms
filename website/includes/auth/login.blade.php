@extends('website.layouts.blank')
@section('content')
    <div class="container flex h-screen font-body">
        <div class="absolute bottom-[40rem] -left-4 w-64 h-64 bg-yellow-100 rounded-full mix-blend-multiply filter blur-xl opacity-70 -z-10"></div>
        <div class="absolute bottom-[30rem] right-0 w-72 h-72 bg-green-300 rounded-full mix-blend-multiply filter blur-xl opacity-70 -z-10"></div>
        <div class="absolute bottom-[7rem] left-20 w-72 h-72 bg-blue-300 rounded-full mix-blend-multiply filter blur-xl opacity-70 -z-10"></div>
        <div class="m-auto w-96 p-6 border rounded-lg shadow-lg bg-white">
            <h1 id="model-title" class="text-3xl font-semibold text-gray-800 text-center">Waitlist</h1>
            <div class="mt-4 text-gray-800">
                <form onsubmit="return false;" method="post">
                    <p id="model-description" class="text-gray-600 font-body">
                        In the next step, we’ll request access to your email address. This is needed to send you an invitation. We’ll only email you regarding your invitation.
                    </p>
                    <button type="button"
                            id="js-model-cta"
                            class="w-full mt-4 border-2 border-primary bg-primary text-white px-6 py-3 rounded-lg">
                        Put me on the list
                    </button>
                </form>
                <div id="error-message" class="text-red-500 mt-2 text-center"></div>
            </div>
        </div>
    </div>
@endsection

@pushonce('end_of_body_login')
<script>
    // Get redirect url
    document.getElementById('js-model-cta').addEventListener('click', function () {
        let xhr = new XMLHttpRequest();
        xhr.open('GET', '{{ getServiceApi() }}/confetti-cms/auth/login', true);
        xhr.responseType = 'json';
        xhr.setRequestHeader('Accept', 'application/json');
        xhr.onload = function () {
            let status = xhr.status;
            if (status === 200) {
                let date = new Date();
                date.setTime(date.getTime() + (10 * 60 * 1000));
                let expires = "; expires=" + date.toUTCString();
                document.cookie = "state=" + xhr.response["state"] + expires + "; path=/";
                // set cookie to redirect to this page after login
                document.cookie = "redirect_after_login=" + window.location.href + "; path=/";
                window.location.href = xhr.response["redirect_url"];
            } else {
                console.error(status, xhr.response);
            }
        };
        xhr.send()
        console.log("request send");
    });
</script>
@endpushonce

