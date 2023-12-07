import { Alert, Snackbar } from "@mui/material";
import React, { Dispatch, SetStateAction } from "react";

type ErrorSnackbarProps = {
    error: string | null;
    setError: Dispatch<SetStateAction<string | null>>;
};

export default function ErrorSnackbar({ error, setError }: ErrorSnackbarProps) {
    return (
        <Snackbar
            open={!!error}
            onClose={() => setError(null)}
            autoHideDuration={6000}
        >
            <Alert severity="error">{String(error)}</Alert>
        </Snackbar>
    );
}
