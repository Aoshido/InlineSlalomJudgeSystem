import { useState, useEffect } from "react";

export default function Judge() {
    const [form, setForm] = useState({
        tournamentCode: "",
        judgeName: "",
    });

    const [joined, setJoined] = useState(false);
    const [events, setEvents] = useState([]);

    function update(field, value) {
        setForm((prev) => ({
            ...prev,
            [field]: value,
        }));
    }

    async function joinTournament() {
        if (!form.tournamentCode || !form.judgeName) return;

        // (for now: no backend join endpoint needed)
        setJoined(true);
    }

    // Mercure subscription
    useEffect(() => {
        if (!joined) return;

        const url = new URL("http://localhost:3000/.well-known/mercure");
        url.searchParams.append(
            "topic",
            `tournament/${form.tournamentCode}`
        );

        const es = new EventSource(url);

        es.onmessage = (event) => {
            const msg = JSON.parse(event.data);

            console.log("Judge received:", msg);

            setEvents((prev) => [...prev, msg]);
        };

        es.onerror = (err) => {
            console.error("Mercure error:", err);
        };

        return () => es.close();
    }, [joined]);

    return (
        <div style={{ padding: 40 }}>
            <h2>Judge Panel</h2>

            {!joined ? (
                <>
                    <input
                        placeholder="Tournament code"
                        value={form.tournamentCode}
                        onChange={(e) => update("tournamentCode", e.target.value)}
                    />

                    <input
                        placeholder="Judge name"
                        value={form.judgeName}
                        onChange={(e) => update("judgeName", e.target.value)}
                    />

                    <button onClick={joinTournament}>
                        Join tournament
                    </button>
                </>
            ) : (
                <div>
                    <h3>Live feed</h3>

                    {events.map((e, i) => (
                        <div key={i}>
                            <pre>{JSON.stringify(e, null, 2)}</pre>
                        </div>
                    ))}
                </div>
            )}
        </div>
    );
}