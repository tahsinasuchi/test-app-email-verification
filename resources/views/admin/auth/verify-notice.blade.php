<x-layout :title="'Verify Email'">
    <h1>Verify Email</h1>
    <p>Please check your email for a verification link.</p>
    <form method="post" action="{{ route('admin.verification.send') }}">
        @csrf
        <button type="submit">Resend verification email</button>
    </form>
</x-layout>
