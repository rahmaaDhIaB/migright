{{--<!DOCTYPE html>--}}
{{--<html>--}}
{{--<head>--}}
{{--    <title>Nouvelle demande d'aide affectée à votre attention</title>--}}
{{--</head>--}}
{{--<body>--}}
{{--<h1>Bonjour, {{ $user->name }}</h1>--}}
{{--<p>You have been assigned a new demand.</p>--}}
{{--<p><strong>Demand Details:</strong></p>--}}
{{--<ul>--}}
{{--    <li><strong>First Name:</strong> {{ $demand->first_name }}</li>--}}
{{--    <li><strong>Last Name:</strong> {{ $demand->last_name }}</li>--}}
{{--    <li><strong>Email:</strong> {{ $demand->email }}</li>--}}
{{--    <li><strong>Phone Number:</strong> {{ $demand->phone_number }}</li>--}}
{{--    <li><strong>Description:</strong> {{ $demand->description }}</li>--}}
{{--</ul>--}}
{{--<p>Please log in to your account to view more details.</p>--}}
{{--<p>Thank you!</p>--}}
{{--</body>--}}
{{--</html>--}}
    <!DOCTYPE html>
<html>
<head>
    <title>Nouvelle demande d'aide affectée à votre attention</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 20px auto;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .header {
            background-color: #007BFF;
            color: #ffffff;
            padding: 10px 20px;
            border-radius: 8px 8px 0 0;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
        }
        .content {
            padding: 20px;
        }
        .content p {
            margin: 10px 0;
            font-size: 16px;
            line-height: 1.5;
        }
        .content ul {
            padding-left: 20px;
        }
        .content ul li {
            margin: 5px 0;
            font-size: 16px;
        }
        .footer {
            text-align: center;
            padding: 10px;
            font-size: 12px;
            color: #777777;
            border-top: 1px solid #dddddd;
            margin-top: 20px;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <h1>Nouvelle demande d'aide affectée à votre attention</h1>
    </div>
    <div class="content">
        <p>Bonjour, <strong>{{ $user->name }}</strong></p>
        <p>Une nouvelle demande d'aide a été affectée à votre attention.</p>
        <p><strong>Détails de la demande :</strong></p>
        <ul>
            <li><strong>Type de la demande :</strong> {{ $demandType }}</li>
            <li><strong>Date de soumission :</strong> {{ $demand->created_at->format('d/m/Y') }}</li>
        </ul>
        <p>Nous vous serions reconnaissants si vous pouviez examiner cette demande dès que possible et prendre les mesures nécessaires pour apporter l'aide requise.</p>
        <p>Pour consulter la demande et y répondre, veuillez vous connecter à votre tableau de bord.</p>
        <p>Merci d'avance pour votre coopération et votre diligence.</p>
        <p>Cordialement,</p>
    </div>
    <div class="footer">
        <p>&copy; {{ date('Y') }} Dhiab Rahma. Tous droits réservés.</p>
    </div>
</div>
</body>
</html>
