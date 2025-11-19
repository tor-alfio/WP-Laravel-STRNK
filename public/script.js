let currentDate = new Date();
const today = new Date();
let selectedDate = null;
let a=0;
let originalHeadersArray = new Array(10);
let originalHeaders = ``;
let b=0;
let originalTrainingsHTMLArray = new Array(10);
let originalTrainingsHTML = ``;
const clientId = '378e160c4c60409c8214152d359724b9';
const redirectUri = 'https://irmgard-erythroblastic-oliva.ngrok-free.dev/callback';
let c2=0;
const csrfMeta = document.querySelector('meta[name="csrf-token"]');
const csrfToken = csrfMeta ? csrfMeta.getAttribute('content') : null;
function renderCalendar(date) {
    const calendarGrid = document.getElementById("calendar-grid");
    const monthYear = document.getElementById("month-year");
    if (!calendarGrid || !monthYear) {
        return;
    }
    const year = date.getFullYear();
    const month = date.getMonth();

    const firstDay = new Date(year, month, 1);
    const lastDay = new Date(year, month + 1, 0);
    const daysInMonth = lastDay.getDate();

    const startDay = (firstDay.getDay() + 6) % 7;

    calendarGrid.innerHTML = '';
    monthYear.textContent = date.toLocaleString('it-IT', { month: 'long', year: 'numeric' });

    for (let i = 0; i < startDay; i++) {
        const emptyCell = document.createElement('div');
        calendarGrid.appendChild(emptyCell);
    }

    for (let day = 1; day <= daysInMonth; day++) {
        const dayCell = document.createElement('div');
        dayCell.textContent = day;

        const dateKey = `${year}-${month + 1}-${day}`;
        if (selectedDate === dateKey) {
            dayCell.classList.add('selected');
        }

        const isToday =
            day === today.getDate() &&
            month === today.getMonth() &&
            year === today.getFullYear();

        if (isToday) {
            dayCell.classList.add('today');
            dayCell.classList.add('selected');
        }

        dayCell.addEventListener('click', () => {
            document.querySelectorAll('#calendar-grid div').forEach(cell => {
                cell.classList.remove('selected');
            });
            selectedDate = dateKey;
            dayCell.classList.add('selected');
            renderWorkout(selectedDate);
            console.log("Hai selezionato:", selectedDate);
        });

        calendarGrid.appendChild(dayCell);
    }
}
const CAT_API_KEY = "live_lSeU5nr7FCNMtfCg00txu5o74DsC7pLUSEBHFKEndNQD6MYbBSwO7BaoSux0BS5Z";

async function generateCatImage() {
    const button = document.getElementById('generate-cat');
    const preview = document.getElementById('cat-preview');
    const hiddenInput = document.getElementById('profile_image');

    button.disabled = true;
    button.textContent = "Genero...";

    try {
        const res = await fetch("https://api.thecatapi.com/v1/images/search", {
            headers: { "x-api-key": CAT_API_KEY }
        });

        if (!res.ok) throw new Error(`Errore API: ${res.status}`);

        const data = await res.json();
        const imageUrl = data[0].url;

        preview.src = imageUrl;
        preview.style.display = "inline-block";
        hiddenInput.value = imageUrl;

        console.log("Immagine generata:", imageUrl);
    } catch (err) {
        console.error("Errore caricamento immagine:", err);
        alert("Errore nel caricamento dell'immagine ");
    } finally {
        button.disabled = false;
        button.textContent = " Rigenera immagine";
    }
}

function renderWorkout(datakey){
    console.log(datakey)
    fetch('/api/get-Training', {
        method: 'POST',
        headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': csrfToken
        },
        body: JSON.stringify({ data: datakey })
    })
        .then(response => {
            if (!response.ok) throw new Error('Errore nel server');
            return response.json();
        })
        .then(data => {
            const contenuto = data.name || "Nessun allenamento per questa data";
            const display = document.getElementById("training-of-the-day");
            if (contenuto != "Nessun allenamento per questa data"){
                const button = document.createElement('button');
                button.classList.add("workout-detail-button");
                button.setAttribute("onclick", "displayWorkoutHome(this)");
                button.textContent = contenuto;
                display.innerHTML =``;
                display.appendChild(button);
            }else {display.textContent = contenuto;}
        })
        .catch(error => {
            console.error('Errore fetch:', error);
        });
}
function displayWorkoutHome(button){
    const WorkoutName = button.innerText;
    window.location.href = `/allenamentiHome?WorkoutName=${encodeURIComponent(WorkoutName)}`;
}
function displayWorkout(button){
    const workoutName = button.innerText;
    const button1 = document.createElement('button');
    button1.textContent = '↩';
    button1.classList.add('button-back');
    button1.onclick = () => restoreHeaders();
    const button2 = document.createElement('button');
    button2.textContent = 'X';
    button2.classList.add('button-back');
    button2.onclick = () => deleteWorkout(workoutName);
    const button3 = document.createElement('button');
    button3.textContent = '↪';
    button3.title ='inoltra a';
    button3.classList.add('button-back');
    button3.onclick = () => sendWorkout(workoutName);
    const buttons_wrapper = document.getElementById('buttons-wrapper');
    buttons_wrapper.appendChild(button1);
    buttons_wrapper.appendChild(button2);
    buttons_wrapper.appendChild(button3);
    const headers = document.getElementById('training-headers');
    originalHeadersArray[b] = headers.innerHTML;
    console.log(originalHeadersArray[b]);
    console.log(b);
    headers.innerHTML = `
        <li class="workout-headers">Week</li>
        <li class="workout-headers">Day</li>
        <li class="workout-headers">Esercizio</li>
        <li class="workout-headers">Sets</li>
        <li class="workout-headers">Reps</li>
        <li class="workout-headers">Peso</li>
        <li class="workout-headers">Variante</li>
        <li class="workout-headers">RPE</li>
    `;
    fetch('/api/show-Exercises', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
            'X-CSRF-TOKEN': csrfToken
        },
        body: new URLSearchParams({ workout: workoutName })
    })
        .then(response => response.json())
        .then(data => {
            console.log(data);
            const container = document.getElementById('trainings-display');
            let c = 0;
            if (window.location.pathname.endsWith("programmazione") && c == 0) {
                const a = document.createElement('button');
                a.classList.add("button-back");
                a.classList.add("no-absolute");
                a.onclick = () => addExercise(workoutName);
                a.innerText = "+";
                buttons_wrapper.appendChild(a);
                c = 1;
            }
            originalTrainingsHTMLArray[b] = container.innerHTML;
            b++;

            container.innerHTML = '';
            data.forEach(ex => {
                const row = document.createElement('ul');
                row.classList.add('trainings-display');
                row.innerHTML = `
                <li class="training-detail">${ex.week}</li>
                <li class="training-detail">${ex.day}</li>
                <li class="training-detail">${ex.name}</li>
                <li class="training-detail">${ex.sets}</li>
                <li class="training-detail">${ex.reps}</li>
                <li class="training-detail">${ex.weight}</li>
                <li class="training-detail">${ex.variant}</li>
                <li class="training-detail">${ex.RPE}</li>
            `;
                container.appendChild(row);
            });
        })
        .catch(error => {
            console.error('Errore nella richiesta:', error);
        });
}
function sendWorkout(workoutName){
    fetch('/api/get-Users')
        .then(response => response.json())
        .then(data => {
            console.log(data);
            const container = document.getElementById('training-headers');
            originalHeadersArray[b]= container.innerHTML;
            console.log(originalHeadersArray[b]);
            console.log(b);
            container.innerHTML = `
                        <li class="training-headers">Nome</li>
                        <li class="training-headers"></li>
                        <li class="training-headers">Specialità</li>
                        <li class="training-headers">Ruolo</li>
                        <li class="training-headers">Invia</li>
                        <li class="training-headers">Total P.B.</li>`;
            const container2 = document.getElementById('trainings-display');
            originalTrainingsHTMLArray[b]=container2.innerHTML;
            console.log(originalTrainingsHTMLArray[b]);
            console.log(b);
            b++;
            container2.innerHTML =``;
            data.utente.forEach(us => {
                const row = document.createElement('ul');
                row.classList.add('trainings-display');
                row.innerHTML = `
                <li class="training-detail">${us.nome_completo}</li>
                <li class="training-detail"><div class="profile_container"><img src="${us.pfp}"</div>'</li>
                <li class="training-detail">${us.specialita}</li>
                <li class="training-detail">${us.ruolo}</li>
                <li class="training-detail"><button data-userid="${us.id}" class="workout-detail-button" onclick="sendWorkoutUser(this, '${workoutName}')">Invia</button></li>
                <li class="training-detail"></li>
            `;
                container2.appendChild(row);
            });
        })
        .catch(error => {
            console.error('Errore nella richiesta:', error);
        });
}
function sendWorkoutUser(user, workoutName) {
    const userid = user.getAttribute('data-userid');
    console.log(userid);
    console.log(workoutName);
    fetch("/api/send-Workout", {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken
        },
        credentials: 'same-origin',
        body: JSON.stringify({ id: userid, wid: workoutName })
    })
    .then(res => res.json())
    .then(data => {
        user.innerHTML = "Inviato";
        console.log("Risposta dal server:", data);
    })
    .catch(err => {
        console.error("Errore nella fetch:", err);
        user.innerHTML = "Errore";
    });
}

function loadUsers() {
    fetch('/api/get-Users')
        .then(res => res.json())
        .then(data => {
            const container = document.getElementById('trainings-display');
            container.innerHTML = '';
            data.utente.forEach(u => {
                const row = document.createElement('ul');
                row.classList.add('trainings-display');
                row.innerHTML = `
                    <li class="training-detail">${u.nome_completo}</li>
                    <li class="training-detail">
                        <div class="profile_container"><img src="${u.pfp}" alt="profile"></div>
                    </li>
                    <li class="training-detail">${u.specialita}</li>
                    <li class="training-detail">${u.ruoli}</li>
                    <li class="amicizia training-detail"></li>
                    <li class="training-detail"></li>
                `;
                container.appendChild(row);
                const amiciziaEl = row.querySelector('.amicizia');
                verificaAmicizia(u.id, data.user, amiciziaEl);
            });
        });
}
function addWorkout(){
    const training_wrapper = document.getElementById('trainings-wrapper');
    training_wrapper.innerHTML = `
    <form id="workout-form" method="POST" action="/api/add-Workout" class="workout-form">
        <input type="hidden" name="_token" value="${csrfToken}">
        <div class="form-fields">
            <label class="login_label_text" for="nome">Nome Workout</label>
            <input class="login_label" type="text" id="nome" name="nome">

            <label class="login_label_text" for="days">Numero Giorni</label>
            <input class="login_label" type="number" id="days" name="days">

            <div id="single-date">
                <label class="login_label_text" for="date">Data</label>
                <input class="login_label" type="date" id="date" name="date">
            </div>
            <label class="login_label_text">
                <input type="checkbox" id="show-extra" onclick="toggleExtraFields()">
                Programmazione
            </label>
            <button type="submit" class="submit_button">Salva Workout</button>
        </div>
        <div id="extra-fields" class="form-fields hidden">
            <label class="login_label_text" for="weeks">Numero Weeks</label>
            <input class="login_label" type="number" id="weeks" name="weeks" min="1">

            <label class="login_label_text" for="start_date">Data Inizio</label>
            <input class="login_label" type="date" id="start_date" name="start_date">

            <label class="login_label_text" for="finish_date">Data Fine</label>
            <input class="login_label" type="date" id="finish_date" name="finish_date">

            <label class="login_label_text" for="type">Tipo di Workout</label>
            <select id="type" name="type">
                <option value="">-- Seleziona --</option>
                <option value="Powerlifting">Powerlifting</option>
                <option value="Bodybuilding">Bodybuilding</option>
                <option value="CrossFit">CrossFit</option>
                <option value="Ipertrofia">Ipertrofia</option>
                <option value="Forza">Forza</option>
            </select>
        </div>
    </form>
    `;
}

function deleteWorkout(workoutName) {
    if (confirm(`Sei sicuro di voler eliminare l'allenamento "${workoutName}"?`)) {
        fetch('/api/delete-Workout', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
                'X-CSRF-TOKEN': csrfToken
            },
            body: new URLSearchParams({ nome: workoutName })
        })
            .then(response => {
                if (response.ok) {
                    location.reload();
                } else {
                    alert("Errore durante l'eliminazione");
                }
            });
    }
}
function addExercise(workoutName) {
    const trainingsDisplay = document.getElementById('trainings-display');
    if (c2 === 0) {
        trainingsDisplay.insertAdjacentHTML('beforeend', `
            <form id="exercise-form" class="exercise-form">
                <div id="exercise_list">
                    ${generateExerciseFields()}
                </div>
                <div id="common_info">
                    <input type="hidden" name="Workout" value="${workoutName}">
                    <button type="button" id="add-row" class="submit_button">➕ Aggiungi Riga</button>
                    <button type="submit" class="submit_button">Salva Esercizi</button>
                </div>
            </form>
        `);

        c2 = 1;
        loadExercisesFromDB();

        document.getElementById('add-row').addEventListener('click', () => {
            document.getElementById('exercise_list').insertAdjacentHTML('beforeend', generateExerciseFields());
            loadExercisesFromDB();
        });
        document.getElementById('exercise-form').addEventListener('submit', e => {
            e.preventDefault();
            const formData = new FormData(e.target);

            fetch('/api/add-Exercise', {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': csrfToken },
                body: formData
            })
                .then(res => res.json())
                .then(data => {
                    alert("Inseriti " + data.inserted + " esercizi");
                    window.location.reload();
                })
                .catch(err => console.error('Errore:', err));
        });
    } else {
        document.getElementById('exercise_list').insertAdjacentHTML('beforeend', generateExerciseFields());
    }
}
function generateExerciseFields() {
    return `
        <div class="exercise_row">
            <input class="exercise_label" type="number" name="week[]" min="1" placeholder="Settimana">
            <input class="exercise_label" type="number" name="day[]" min="1" max="7" placeholder="Giorno">
            
            <select class="exercise_label exercise-select" name="exercise[]">
                <option value="">Caricamento...</option>
            </select>
            
            <input class="exercise_label" type="number" name="sets[]" min="1" placeholder="Serie">
            <input class="exercise_label" type="number" name="reps[]" min="1" placeholder="Ripetizioni">
            <input class="exercise_label" type="number" name="peso[]" step="0.1" min="0" placeholder="Peso (kg)">
            <input class="exercise_label" type="text" name="variante[]" placeholder="Variante">
            <input class="exercise_label" type="number" name="rpe[]" step="0.5" min="1" max="10" placeholder="RPE">
        </div>
    `;
}
function loadExercisesFromDB() {
    fetch('/api/get-Exercises')
        .then(res => res.json())
        .then(data => {
            const selects = document.querySelectorAll('.exercise-select');
            selects.forEach(select => {
                select.innerHTML = '<option value="">-- Seleziona esercizio --</option>';
                data.forEach(ex => {
                    const opt = document.createElement('option');
                    opt.value = ex.id;
                    opt.textContent = ex.name;
                    select.appendChild(opt);
                });
            });
        })
        .catch(err => {
            console.error('Errore nel caricamento degli esercizi:', err);
        });
}
function toggleExtraFields() {
    const extra = document.getElementById('extra-fields');
    const singleDate = document.getElementById('single-date');
    const isChecked = document.getElementById('show-extra').checked;

    if (isChecked) {
        extra.classList.remove('hidden');
        singleDate.classList.add('hidden');
        document.getElementById('date').removeAttribute('required');
        document.getElementById('start_date').setAttribute('required', true);
        document.getElementById('finish_date').setAttribute('required', true);
    } else {
        extra.classList.add('hidden');
        singleDate.classList.remove('hidden');
        document.getElementById('date').setAttribute('required', true);
        document.getElementById('start_date').removeAttribute('required');
        document.getElementById('finish_date').removeAttribute('required');
    }
}

function verificaAmicizia(id1, id2, el) {
    fetch("/api/check-Friendship", {
        method: "POST",
        headers: { 
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": csrfToken
        },
        body: JSON.stringify({ id1, id2 })
    })
        .then(res => res.json())
        .then(data => {
            console.log(id1,id2,data.stato);
            if(data.stato ==="non amici"){
                const button = document.createElement('button');
                button.classList.add("send-friendship-button");
                button.textContent = "Invia Amicizia";
                button.onclick = () => sendFriendship(id1, id2);
                el.appendChild(button);
            } else el.innerHTML = data.stato;
        })
        .catch(err => {
            console.error("Errore nella fetch:", err);
            el.innerHTML = "Errore";
        });
}
function sendFriendship(id1, id2){
    fetch("/api/send-Friendship", {
        method: "POST",
        headers: { 
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": csrfToken
        },
        body: JSON.stringify({ id1, id2 })
    })
    .then(res => {
        if (!res.ok) throw new Error("Errore nella risposta del server");
        return res.json();
    })
    .then(data => {
        if(data.success){
        console.log("Richiesta di amicizia inviata:", data);
        location.reload();
        } else {
        console.warn(data.message);
        alert(data.message);
        }
})
    .catch(err => {
        console.error("Errore nell'invio dell'amicizia:", err);
    });
}


function AcceptFriendship(button) {
    const wrapper = button.closest('.notification');
    const friendDiv = wrapper.querySelector('.friend');
    const id2 = friendDiv.getAttribute('data-id2');
    const notification = button.getAttribute('data-notification');

    const formData = new FormData();
    formData.append('id2', id2);
    formData.append('notification', notification);

    fetch("/api/accept-Friendship", {
        method: "POST",
        headers: { 
            "X-CSRF-TOKEN": csrfToken
        },
        body: formData
    })
    .then(res => {
        if (!res.ok) throw new Error("Errore nella risposta del server");
        return res.json();
    })
    .then(data => {
        console.log("Richiesta accettata:", data);
    })
    .catch(err => {
        console.error("Errore:", err);
    });
}



function notificationManager() {
    fetch("/api/get-Notifications")
    .then(res => {
        if (!res.ok) throw new Error("Errore nella risposta del server");
        return res.json();
    })
    .then(notifiche => {
        let k = 0;
        const wrapper = document.getElementById("notifications-wrapper");
        wrapper.innerHTML = "";

        notifiche.forEach(n => {
            if (n.seen == 0) {

                const notification = document.createElement("div");
                notification.className = "notification";

                if (n.type == "amicizia") {
                    notification.innerHTML = `
                        <img src="${n.pfp}">
                        <div>
                            <div class="friend" data-id2="${n.sentBy}">
                                ${n.nome_completo}
                            </div> ti ha inviato una richiesta di amicizia
                        </div>
                        <button data-notification="${n.id}" onclick="AcceptFriendship(this)">
                            Accetta
                        </button>
                    `;
                }

                if (n.type == "allenamentoCoach") {
                    notification.innerHTML = `
                        <img src="${n.pfp}">
                        <div>
                            <div class="friend" data-id2="${n.sentBy}">
                                ${n.nome_completo}
                            </div> ti ha inviato ${n.text}
                        </div>
                    `;
                }

                wrapper.appendChild(notification);
                k++;
            }
        });

        if (k === 0) {
            const empty = document.createElement("div");
            empty.className = "notification";
            empty.innerHTML = `
                <div>Non ci sono nuove notifiche.</div>
                <button>Clicca per consultare lo storico notifiche</button>
            `;
            wrapper.appendChild(empty);
        }

        document.getElementById("notifications-number").innerText = k;
    })
    .catch(err => {
        console.error("Errore nel trovare notifiche:", err);
    });
}

function RandomMotivationalQuote() {
    const originalUrl = "https://zenquotes.io/api/random?ts=" + new Date().getTime();
    const encodedUrl = encodeURIComponent(originalUrl);
  
    fetch("https://api.allorigins.win/get?url=" + encodedUrl)
      .then(res => res.json())
      .then(data => {
        const parsed = JSON.parse(data.contents);
        const quoteWrapper = document.getElementById("quote");
        quoteWrapper.innerHTML = `${parsed[0].q} — ${parsed[0].a}`;
        console.log("Citazione aggiornata");
      })
      .catch(err => {
        console.error("Errore:", err);
      });
  }
function restoreHeaders() {
    console.log(b);
    b--;
    console.log(b);
    if(b==0){
        const a = document.getElementById('trainings-wrapper');
        a.firstElementChild.innerHTML = ``;
    }
    document.getElementById('training-headers').innerHTML = originalHeadersArray[b];
    document.getElementById('trainings-display').innerHTML = originalTrainingsHTMLArray[b];
}
function showNotifications(){
    const a = document.getElementById("notifications-wrapper");
    console.log("cliccato");
    a.style.visibility = "visible";
}
function changeMonth(offset) {
    currentDate.setMonth(currentDate.getMonth() + offset);
    renderCalendar(currentDate);
}
async function checkSpotifyLogin() {
    const token = localStorage.getItem('access_token');
    if ((token) && (await isTokenValid(token))) {
        showSpotifyTrack(token);
    } else {
        showLoginButton();
    }
}

async function isTokenValid(token) {
    try {
        const response = await fetch("https://api.spotify.com/v1/me", {
            headers: {
                Authorization: `Bearer ${token}`
            }
        });
        return response.ok;
    } catch (err) {
        console.error("Errore nel controllo token:", err);
        return false;
    }
}
function showLoginButton() {
    const wrapper = document.getElementById("spotify-track");
    wrapper.innerHTML = `<button id="spotify-login-btn">Login con Spotify</button>`;
    document.getElementById("spotify-login-btn").addEventListener("click", startSpotifyLogin);
}
const generateRandomString = (length) => {
    const possible = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
    const values = crypto.getRandomValues(new Uint8Array(length));
    return values.reduce((acc, x) => acc + possible[x % possible.length], "");
}

const sha256 = async (plain) => {
    const encoder = new TextEncoder()
    const data = encoder.encode(plain)
    return window.crypto.subtle.digest('SHA-256', data)
}
const base64encode = (input) => {
    return btoa(String.fromCharCode(...new Uint8Array(input)))
        .replace(/=/g, '')
        .replace(/\+/g, '-')
        .replace(/\//g, '_');
}

async function startSpotifyLogin() {
    const codeVerifier = generateRandomString(64);
    const hashed = await sha256(codeVerifier);
    const codeChallenge = base64encode(hashed);

    localStorage.setItem("code_verifier", codeVerifier);

    const scope = "user-library-read user-read-private user-read-email";

    const params = new URLSearchParams({
        response_type: "code",
        client_id: clientId,
        scope,
        code_challenge_method: "S256",
        code_challenge: codeChallenge,
        redirect_uri: redirectUri
    });

    window.location.href =
        "https://accounts.spotify.com/authorize?" + params.toString();
}

const getToken = async code => {

    const codeVerifier = localStorage.getItem('code_verifier');

    const url = "https://accounts.spotify.com/api/token";
    const payload = {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: new URLSearchParams({
            client_id: clientId,
            grant_type: 'authorization_code',
            code,
            redirect_uri: redirectUri,
            code_verifier: codeVerifier,
        }),
    }

    try {
        const response = await fetch(url, payload);
        const data = await response.json();

        if (data.access_token) {
            localStorage.setItem('access_token', data.access_token);
            console.log("Access token salvato:", data.access_token);
            window.location.href = "{{ route('home') }}";
        } else {
            console.error("Errore nella risposta:", data);
        }
    } catch (error) {
        console.error("Errore durante il fetch del token:", error);
    }
}
function handleSpotifyRedirect() {
    const params = new URLSearchParams(window.location.search);
    const code = params.get("code");

    if (code) {
        getToken(code);
    } else {
        console.error("Codice mancante nella redirect URL");
    }
}
function showSpotifyTrack(token) {
    fetch("https://api.spotify.com/v1/me/tracks", {
        headers: {
            "Authorization": "Bearer " + token
        }
    })
    .then(res => res.json())
    .then(data => {
        const wrapper = document.getElementById("spotify-track");
        if (!data.items || data.items.length === 0) {
            wrapper.innerHTML = "<p>Nessun brano salvato trovato.</p>";
            return;
        }
        const random = data.items[Math.floor(Math.random() * data.items.length)].track;
        wrapper.innerHTML = `
            <p>Brano consigliato per inizare il tuo allenamento</p>
            <iframe src="https://open.spotify.com/embed/track/${random.id}" 
                width="100%" height="80" frameborder="0" allowtransparency="true" 
                allow="autoplay; clipboard-write; encrypted-media; fullscreen; picture-in-picture">
            </iframe>
        `;
    })
}

window.addEventListener('DOMContentLoaded', () => {
    const dateKey = `${currentDate.getFullYear()}-${String(currentDate.getMonth() + 1).padStart(2, '0')}-${String(currentDate.getDate()).padStart(2, '0')}`;
    renderCalendar(currentDate);
    renderWorkout(dateKey);
    notificationManager();
    RandomMotivationalQuote();
    checkSpotifyLogin();
    if (window.location.pathname === '/users') {
        loadUsers();
    }
    document.addEventListener("click", function (event) {
        const wrapper = document.getElementById("notifications-wrapper");
        const notificationButton = document.getElementById("notification-button");
        const isClickInside = wrapper.contains(event.target) || notificationButton.contains(event.target);
        if (!isClickInside) {
            wrapper.style.visibility = "hidden";
        }
    });
    const toggleButton = document.getElementById('mobile-menu-toggle');
    const navWrapper = document.getElementById('nav-button-wrapper');

    toggleButton.addEventListener("click", () => {
        navWrapper.classList.toggle('show');
    });
    window.addEventListener("resize", () => {
        if (window.innerWidth > 768) {
            navWrapper.classList.remove('show');
        }
    });
    const urlParams = new URLSearchParams(window.location.search);
    const workoutName = urlParams.get('WorkoutName');

    if(workoutName) {
        const dummyButton = { innerText: workoutName };
        displayWorkout(dummyButton);
    }
});