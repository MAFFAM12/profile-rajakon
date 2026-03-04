import { toast } from "sonner";

export const checkForError = (flash, setValidationStatus, key) => {
    if (flash?.['error'] != null) {
        toast.error('Error', {
            description: flash?.['error']
        })

        return;
    }

    setValidationStatus((prevState) => {
        prevState[key] = 'error';

        return ({
            ...prevState
        });
    });
    return flash?.['validation-error']?.[key]?.[0];
} 