const API_KEY = "d491978ec846ea39ba941f0c0ce67df7";
const CURRENT_WEATHER_URL = "https://api.openweathermap.org/data/2.5/weather";
const FORECAST_URL = "https://api.openweathermap.org/data/2.5/forecast";

const cityInput = document.getElementById('city-input');
const weatherButton = document.getElementById('weather-button');
const currentResultsDiv = document.getElementById('current-results');
const forecastResultsDiv = document.getElementById('forecast-results');

const kelvinToCelsius = (k) => (k - 273.15).toFixed(1);

function getCurrentWeather(city) {
    const url = `${CURRENT_WEATHER_URL}?q=${city}&appid=${API_KEY}`;
    
    const xhr = new XMLHttpRequest();

    xhr.onload = function() {
        if (xhr.status === 200) {
            const data = JSON.parse(xhr.responseText);
            console.log('Aktualna Pogoda:', data);
            displayCurrentWeather(data);
        } else {
            currentResultsDiv.innerHTML = `<p style="color: red;">Błąd ${xhr.status}: Nie znaleziono miasta.</p>`;
        }
    };
    
    xhr.onerror = function() {
        currentResultsDiv.innerHTML = `<p style="color: red;">Błąd sieciowy. Sprawdź połączenie.</p>`;
    };

    xhr.open('GET', url);
    xhr.send();
    
    currentResultsDiv.innerHTML = `<p>Ładowanie bieżącej pogody...</p>`;
}

function displayCurrentWeather(data) {
    const tempC = kelvinToCelsius(data.main.temp);
    const feelsLikeC = kelvinToCelsius(data.main.feels_like);

    currentResultsDiv.innerHTML = `
        <h3>Pogoda w ${data.name}, ${data.sys.country}</h3>
        <p>Temperatura: <strong>${tempC} °C</strong> (odczuwalna: ${feelsLikeC} °C)</p>
        <p>Warunki: ${data.weather[0].description}</p>
        <p>Wilgotność: ${data.main.humidity}%</p>
        <p>Ciśnienie: ${data.main.pressure} hPa</p>
        <p>Wiatr: ${data.wind.speed} m/s</p>
    `;
}

async function getForecast(city) {
    const url = `${FORECAST_URL}?q=${city}&appid=${API_KEY}`;
    
    forecastResultsDiv.innerHTML = `<p>Ładowanie prognozy...</p>`;

    try {
        const response = await fetch(url);

        if (!response.ok) {
            throw new Error(`Błąd: ${response.status}`);
        }

        const data = await response.json();
        console.log('Prognoza na 5 dni:', data);
        displayForecast(data);

    } catch (error) {
        forecastResultsDiv.innerHTML = `<p style="color: red;">Błąd ładowania prognozy: ${error.message}</p>`;
    }
}

function displayForecast(data) {
    const forecastList = data.list.filter((item, index) => {
        return item.dt_txt.includes("12:00:00");
    });

    let html = '';
    forecastList.forEach(item => {
        const date = new Date(item.dt * 1000).toLocaleDateString('pl-PL', { weekday: 'short', month: 'numeric', day: 'numeric' });
        const tempC = kelvinToCelsius(item.main.temp);
        
        html += `
            <div class="forecast-day">
                <strong>${date}</strong>
                <p>${item.weather[0].description}</p>
                <p>Temp: ${tempC} °C</p>
            </div>
        `;
    });

    forecastResultsDiv.innerHTML = html || `<p>Brak prognozy na najbliższe 5 dni.</p>`;
}

weatherButton.addEventListener('click', () => {
    const city = cityInput.value.trim();

    if (city) {
        getCurrentWeather(city);
        getForecast(city);
    } else {
        alert('Wpisz nazwę miasta.');
    }
});