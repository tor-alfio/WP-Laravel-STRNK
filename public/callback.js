window.onload = handleSpotifyRedirect;
const clientId = '378e160c4c60409c8214152d359724b9';
const redirectUri = 'https://irmgard-erythroblastic-oliva.ngrok-free.dev/callback';
async function handleSpotifyRedirect() {
    const params = new URLSearchParams(window.location.search);
    const code = params.get("code");

    if (!code) {
        console.error("Nessun code trovato nella URL");
        return;
    }

    await getToken(code);
}

async function getToken(code) {
    const codeVerifier = localStorage.getItem("code_verifier");

    if (!codeVerifier) {
        console.error("Code verifier mancante");
        return;
    }

    const payload = new URLSearchParams({
        client_id: clientId,
        grant_type: "authorization_code",
        code,
        redirect_uri: redirectUri,
        code_verifier: codeVerifier
    });

    try {
        const res = await fetch("https://accounts.spotify.com/api/token", {
            method: "POST",
            headers: { "Content-Type": "application/x-www-form-urlencoded" },
            body: payload
        });

        const data = await res.json();

        if (data.access_token) {
            localStorage.setItem("access_token", data.access_token);
            localStorage.removeItem("code_verifier");
            window.location.href = HOME_URL;
        } else {
            console.error("Errore nella risposta Spotify:", data);
        }
    } catch (e) {
        console.error("Errore getToken:", e);
    }
}
