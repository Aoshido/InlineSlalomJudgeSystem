import { useEffect, useState } from "react";

export default function App() {
    const [run, setRun] = useState(null);

    const runId = 1;
    const tournamentId = 1;

    // 1. Initial load (REST API)
    useEffect(() => {
        fetch(`http://localhost:8000/api/run/${runId}`)
            .then((res) => res.json())
            .then((data) => setRun(data))
            .catch((err) => console.error("Failed to load run:", err));
    }, []);

    // 2. Mercure subscription (real-time updates)
    useEffect(() => {
        const url = new URL("http://localhost:3000/.well-known/mercure");

        url.searchParams.append(
            "topic",
            `tournament/${tournamentId}/run/${runId}`
        );

        const eventSource = new EventSource(url);

        eventSource.onmessage = (event) => {
            const message = JSON.parse(event.data);

            console.log("Mercure event received:", message);

            // Only handle execution creation for now
            if (message.type === "execution.created") {
                setRun((prev) => {
                    if (!prev) return prev;

                    return {
                        ...prev,
                        executions: [
                            ...prev.executions,
                            {
                                id: message.executionId,
                                trick: message.data.trick,
                                line: message.data.line,
                                sequence: message.data.sequenceNumber,
                                scores: [],
                            },
                        ],
                    };
                });
            }
        };

        eventSource.onerror = (err) => {
            console.error("Mercure connection error:", err);
        };

        return () => {
            eventSource.close();
        };
    }, []);

    // 3. Render
    if (!run) return <div>Loading...</div>;

    return (
        <div style={{ padding: 20 }}>
            <h1>Skater: {run.skater}</h1>

            <h2>Tricks performed</h2>

            {run.executions.length === 0 ? (
                <p>No tricks yet</p>
            ) : (
                run.executions.map((ex) => (
                    <div
                        key={ex.id}
                        style={{
                            display: "flex",
                            gap: 20,
                            padding: 8,
                            borderBottom: "1px solid #ccc",
                        }}
                    >
                        <strong>{ex.trick}</strong>
                        <span>{ex.line}</span>
                        <span>Seq: {ex.sequence}</span>

                        <span>
              Score:{" "}
                            {ex.scores.length
                                ? ex.scores.reduce((sum, s) => sum + s.score, 0)
                                : 0}
            </span>
                    </div>
                ))
            )}
        </div>
    );
}