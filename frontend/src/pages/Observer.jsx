import { useState } from "react";

export default function Observer() {
    const runId = 1;

    const [trickId, setTrickId] = useState(1);
    const [line, setLine] = useState("A");

    async function sendExecution() {
        await fetch(`http://localhost:8000/api/run/${runId}/execution`, {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
            },
            body: JSON.stringify({
                trickId,
                line,
            }),
        });
    }

    return (
        <div style={{ padding: 40 }}>
            <h2>Observer Panel</h2>

            <div>
                <label>Trick ID:</label>
                <input
                    value={trickId}
                    onChange={(e) => setTrickId(Number(e.target.value))}
                />
            </div>

            <div>
                <label>Line:</label>
                <select value={line} onChange={(e) => setLine(Number(e.target.value))}>
                    <option value={120}>120</option>
                    <option value={80}>80</option>
                    <option value={50}>50</option>
                </select>
            </div>

            <button onClick={sendExecution}>
                Send Execution
            </button>
        </div>
    );
}