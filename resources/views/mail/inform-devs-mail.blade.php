<x-mail::message>
# Support Time Purchased

{{ $user->name }} has purchased some support time.

Please get in touch with them via email as soon as possible.

**Their Email** {{ $user->email }}

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
