@component('mail::message')
# Welcome !

Hi {{ $user->name }}
<br>
Welcome to Talent Insider, your account has been created successfuly!

@component('mail::button', ['url' => route('login')])
Login Here
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
