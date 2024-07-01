let currentDate = new Date("{{ $weekStart->format('Y-m-d') }}");

document.getElementById("prevWeek").addEventListener("click", function () {
    changeWeek(-7);
});

document.getElementById("nextWeek").addEventListener("click", function () {
    changeWeek(7);
});

function changeWeek(days) {
    currentDate.setDate(currentDate.getDate() + days);
    fetchWeekData(currentDate);
}

function fetchWeekData(date) {
    const formattedDate = date.toISOString().split("T")[0];
    fetch(`/user-dashboard?date=${formattedDate}`)
        .then((response) => response.json())
        .then((data) => {
            updateTable(data);
        });
}

function updateTable(data) {
    const weekOf = document.getElementById("weekOf");
    const weekDays = document.getElementById("weekDays");
    const weekData = document.getElementById("weekData");

    const startDate = new Date(data.weekStart);
    weekOf.innerText = startDate.toLocaleDateString("en-US", {
        month: "short",
        day: "numeric",
        year: "numeric",
    });

    weekDays.innerHTML = "";
    weekData.innerHTML = "";

    for (let day = 0; day < 7; day++) {
        const currentDay = new Date(startDate);
        currentDay.setDate(startDate.getDate() + day);
        const dayHeader = document.createElement("th");
        dayHeader.innerText = currentDay.toLocaleDateString("en-US", {
            weekday: "short",
            month: "short",
            day: "numeric",
        });
        weekDays.appendChild(dayHeader);

        const dayData = document.createElement("td");
        const dayString = currentDay.toISOString().split("T")[0];
        const dayEvents = data.events.filter((event) =>
            event.tanggal_mulai.startsWith(dayString)
        );
        dayEvents.forEach((event) => {
            const eventDiv = document.createElement("div");
            eventDiv.classList.add("mb-2");
            eventDiv.innerHTML = `
                    <strong>${event.ruangan.nama_ruangan}</strong><br>
                    ${new Date(event.tanggal_mulai).toLocaleTimeString(
                        "en-US",
                        { hour: "2-digit", minute: "2-digit" }
                    )} -
                    ${new Date(event.tanggal_selesai).toLocaleTimeString(
                        "en-US",
                        { hour: "2-digit", minute: "2-digit" }
                    )}<br>
                    Peminjam: ${event.nama_peminjam}
                    <hr>
                `;
            dayData.appendChild(eventDiv);
        });
        weekData.appendChild(dayData);
    }
}
