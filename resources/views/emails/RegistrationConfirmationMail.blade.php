@component('mail::message')
# Introduction


@component('mail::button', ['url' => 'http://localhost:8000/userlogin'])
Activate
@endcomponent

@component('mail::panel')
Registration Complete succesfully. 
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
