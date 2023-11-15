import { Button } from "@mui/material";
import axios from "axios";
import React from "react";

async function logSomething() {
    const res = await axios.post("/api/logSomething");
    console.log(res);
}

export default function KanbanBoard() {
    return (
        <Button variant="contained" onClick={logSomething}>
            Log something
        </Button>
    );
}
