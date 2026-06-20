# Inline Slalom Judge System - Domain Model

## Project Goal

The system is intended to assist judges during an Inline Slalom competition.

The primary goal is to record trick executions and judge evaluations in real time.

The system is not required to automatically determine competition winners in its first version.

---

## Tournament Workflow

1. Chief Judge starts a local server.
2. Chief Judge creates a tournament.
3. A tournament receives a unique short code.
4. Other judges join the tournament using that code.
5. Chief Judge selects the active skater.
6. During the run, Chief Judge records trick executions.
7. Judges receive the trick information immediately.
8. Judges score the execution from -10 to +10.
9. When the run ends, all recorded executions and scores are stored.
10. At the end of the tournament, a report can be generated.

---

## Rules

1. Every trick belongs to exactly one family.
2. Every trick has a yearly classification.
3. Every trick has a yearly rating (A-1, B-10, etc.).
4. Technical score comes from the trick rating.
5. Judges contribute an artistic modifier (-10 to +10).
6. If the same trick is performed multiple times, only the best execution counts.
7. A valid run should contain at least one trick from each family:

    * Sitting
    * Lineals
    * Others
    * Spinning
    * Jumping
8. Missing a family incurs a penalty (currently assumed to be -20 points).
9. Runs last 2 minutes.
10. Trick line (50 / 80 / 120) affects scoring.
11. Judge scores are averaged.

---

## Entities

Tournament

Judge

Skater

Run

RunExecution

JudgeScore

Trick

TrickClassification

---

## Known Families

Sitting

Lineals

Others

Spinning

Jumping

---

## Future Considerations

The official ruleset may change from year to year.

Trick classifications, families and ratings must therefore be versioned by season and must not overwrite historical competition data.
