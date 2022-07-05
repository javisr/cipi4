<!DOCTYPE html>
<html lang="en">

<script>

    quotes = [
        ['The secret of getting ahead is getting started.','Mark Twain'],
        ['It’s hard to beat a person who never gives up.','Babe Ruth'],
        ['Everything you can imagine is real.','Pablo Picasso'],
        ['Do one thing every day that scares you.','Eleanor Roosevelt'],
        ['Simplicity is the ultimate sophistication.','Leonardo da Vinci'],
        ['Well begun is half done.','Aristotle'],
        ['It always seems impossible until it is done.','Nelson Mandela'],
        ['Happiness is not something ready made. It comes from your own actions.','Dalai Lama'],
        ['Whatever you are, be a good one.','Abraham Lincoln'],
        ['Impossible is just an opinion.','Paulo Coelho'],
        ['Your passion is waiting for your courage to catch up.','Isabelle Lafleche'],
        ['If opportunity doesn\'t knock, build a door.','Kurt Cobain'],
        ['Work hard in silence, let your success be the noise.','Frank Ocean'],
        ['Work hard, be kind, and amazing things will happen.','Conan O’Brien'],
        ['In the middle of every difficulty lies opportunity.','Albert Einstein']
    ];
  
    maxQuotes = quotes.length;

    function getRandomSentence() {
        var index = Math.floor(Math.random() * (maxQuotes - 1));
        return quotes[index];
    }

    randquote = getRandomSentence();
  
</script>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Coming Soon...</title>
    <style>
        html {
            font-family: Arial, sans-serif;
            color: #000;
            font-size: 16px;
            font-weight: 400;
        }
        main {
            margin: 5rem 0 0 5rem;
        }
        h1,
        p {
            margin-top: 0;
            margin-bottom: 2rem;
        }
        h1 {
            font-weight: 700;
            font-size: 4.5rem;
        }
        p {
            color: #7d7d7d;
            font-size: 1.75rem;
        }
        @media screen and (max-width: 768px) {
            html {
                font-size: 12px;
            }

            main {
                margin: 3rem 0 0 3rem;
            }
        }
    </style>
</head>

<body>
    <main>
        <h1><script>document.write(randquote[0]);</script></h1>
        <p><script>document.write(randquote[1]);</script></p>
    </main>
</body>

</html>
