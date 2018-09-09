<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, maximum-scale=1">
        <style>
            body{;width:100% !important;min-width: 100%;-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;margin:0;padding:0;height:100%;}
            img {margin-left:0;margin-right:0;margin-top:0;margin-bottom:0;padding-left:0;padding-right:0;padding-top:0;padding-bottom:0;outline:none;-ms-interpolation-mode: bicubic;}
            p {margin-left:0;margin-right:0;margin-top:0;margin-bottom:0;padding-left:0;padding-right:0;padding-top:0;padding-bottom:0;}
            @media only screen and (max-width: 600px) {table[class="steps"] {display: table-caption;}}
        </style>
    </head>
<body>
<p>User({{ $user_id }}) ordered a new guest post finder result</p>

<table width="100%" align="center" cellpadding="0" cellspacing="0" border="0" bgcolor="#ffffff" style="max-width:800px; min-width:800px;">
    <thead>
        <tr>
            <th>URL</th>
            <th>Instructions</th>
            <th>Relevant Article</th>
            <th>Users Article</th>
        </tr>
    </thead>
    <tbody>
        @foreach($domains as $domain)
            <tr>
                <td>{{ $domain['url'] }}</td>
                <td>{{ $domain['anchors'] }}</td>
                <td>{{ $domain['check_article'] }}</td>
                <td>{{ $domain['file_article'] }}</td>
            </tr>
        @endforeach
    </tbody>
</table>


<div class="footer">(c) Linkquidator 2013-2017</div>
</body>
</html>