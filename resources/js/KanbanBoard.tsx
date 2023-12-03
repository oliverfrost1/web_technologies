import { Button } from "@mui/material";
import axios from "axios";
import React from "react";

async function testApi() {
    const res = await axios.post("/api/test");
    const todos = await axios.get("/api/todos");
    console.log(todos);
}

export default function KanbanBoard() {
    return (
        <Button variant="contained" onClick={testApi}>
            Log something
        </Button>
    );
}
