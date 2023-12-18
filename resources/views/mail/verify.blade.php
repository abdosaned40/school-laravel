<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>|Verify  </title>
</head>
<body>
         <p>Hallo  <b>{{ $details['name']  }}</b>


         </p>
         <br>
         <p>The following is your data:</p>
         <table>
            <tr>
                <td>Full name</td>
                <td>:</td>
                <td>{{ $details['name'] }}</td>
            </tr>
            <tr>
                <td>Role</td>
                <td>:</td>
                <td>{{ $details['role'] }}</td>
            </tr>
            <tr>
                <td>Website</td>
                <td>:</td>
                <td>{{ $details['website'] }}</td>
            </tr>
            <tr>
                <td>Tanggal Register</td>
                <td>:</td>
                <td>{{ $details['datetime'] }}</td>
            </tr>
         </table>
         <br><br><br><br>
         <center>
            <h3>Click below to verify your account :</h3>
            <a href="{{ $details['url'] }}" style="text-decoration: none;color: rgb(255,255,255); padding: 9px; background-color:blue; font: bold; border-radius: 20%;">Verify</a>
            <br><br><br>
            <p>
                Copy right @ 2023 | code
            </p>
         </center>
</body>
</html>
