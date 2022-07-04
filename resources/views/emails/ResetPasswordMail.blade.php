@component('mail::message')
# Introduction




@component('mail::panel')
     <p> We recieved a password reset request.</p>
      <p>Here is your password reset link: </p>
      @component('mail::button', ['url' => $url])
Click here
@endcomponent;
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
