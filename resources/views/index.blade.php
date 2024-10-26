<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LinkZip URL Shortener</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gradient-to-r from-indigo-600 to-purple-600 min-h-screen flex items-center justify-center p-4">

    <div class="w-full max-w-md bg-white rounded-lg shadow-lg p-8 transform transition duration-500 hover:scale-105">
        <h2 class="text-lg font-bold text-center text-gray-800 mb-4">🔗 LinkZip URL Shortener</h2>
        <p class="text-gray-600 text-center mb-6">Enter a long URL to make it shorter and easy to share.</p>

        <form class="space-y-4" id="urlForm" action="{{ url('/shorten') }}" method="POST">
            @csrf
            <input type="url" id="url" placeholder="Paste your long URL here..." class="w-full p-3 text-gray-700 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500" required>
            
            <button type="submit" class="w-full py-3 bg-indigo-600 text-white font-semibold rounded-md shadow-md hover:bg-indigo-700 transition duration-300 ease-in-out transform hover:scale-105">Shorten URL</button>
        </form>

        <div class="mt-6">
            <p class="text-gray-500 text-center">Your shortened URL will appear below:</p>
            <div class="mt-4 bg-gray-100 p-3 rounded-md flex justify-between items-center shadow-inner">
                <span id="short-url" class="text-indigo-600 font-medium truncate">http://short.ly/xyz123</span>
                <button  id="copy" class="text-indigo-600 hover:text-indigo-800">Copy</button>
            </div>
        </div>

        <footer class="mt-8 text-center text-gray-400 text-sm">
            Built with 💙 by Adams Roland
        </footer>
    </div>
>

<!-- Copy Button -->

    <script>
        document.getElementById('copy').addEventListener('click', () => {
            // Select the input field
            const textToCopy = document.getElementById('short-url');
            
            // Execute the copy command
            navigator.clipboard.writeText(textToCopy.textContent)
                .then(() => {
                    alert('Copied to clipboard!');
                })
                .catch((error) => {
                    console.error('Copy failed', error);
                });
        });
    </script>

    <script>
        document.getElementById('urlForm').addEventListener('submit', async (event) => {
            event.preventDefault();
            
            // Get the URL entered by the user
            const originalUrl = document.getElementById('url').value;

            try {
                // Send a POST request to the server to shorten the URL
                const response = await fetch('http://127.0.0.1:8000/shorten', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}' // Include CSRF token for Laravel
                    },
                    body: JSON.stringify({ url: originalUrl })
                });

                if (!response.ok) {
                    throw new Error('Failed to shorten URL');
                }

                const data = await response.json();

                console.log(data)

                // Display the shortened URL
                document.getElementById('short-url').textContent = data.short_url;
            } catch (error) {
                console.error(error);
            }
        });
    </script>

</body>
</html>
