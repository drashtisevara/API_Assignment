@component('mail::message')
# Welcome to the application, {{ $user->name }}

Thanks for registering with our app.

Regards,<br>
{{ config('app.name') }}
@endcomponent