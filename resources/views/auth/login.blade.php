<h1>Login to Reserve</h1>

@if(session('success'))
    <p style="color:green;">{{ session('success') }}</p>
@endif

@if ($errors->any())
    <ul style="color:red;">
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
@endif

<form method="POST" action="/login">
    @csrf

    <label>Email:</label>
    <input type="email" name="email" value="{{ old('email') }}"><br><br>

    <label>Password:</label>
    <input type="password" name="password"><br><br>

    <button type="submit">Login</button>
    <button type="reset">Clear</button>
</form>

<br>
<a href="/">Introduction</a>
<br>
<a href="/register">Register</a>