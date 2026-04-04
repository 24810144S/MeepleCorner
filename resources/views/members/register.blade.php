<h1>Member Registration</h1>

@if ($errors->any())
    <ul style="color:red;">
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
@endif

<form method="POST" action="/register">
    @csrf

    <label>Last Name:</label>
    <input type="text" name="last_name" value="{{ old('last_name') }}"><br><br>

    <label>First Name:</label>
    <input type="text" name="first_name" value="{{ old('first_name') }}"><br><br>

    <label>Mailing Address:</label>
    <input type="text" name="address" value="{{ old('address') }}"><br><br>

    <label>Phone:</label>
    <input type="text" name="phone" value="{{ old('phone') }}"><br><br>

    <label>Email:</label>
    <input type="email" name="email" value="{{ old('email') }}"><br><br>

    <label>Password:</label>
    <input type="password" name="password"><br><br>

    <label>
        <input type="checkbox" name="subscribe_events" value="1">
        Subscribe to game night events
    </label>
    <br><br>

    <button type="submit">Register</button>
    <button type="reset">Clear</button>
</form>

<br>
<a href="/">Introduction</a>
<br>
<a href="/login">Login</a>