module.exports = (e) => {
    const errors = e.response.data ? e.response.data : e.message ? e.message : e;

    if (e.response) {
        for (let i in errors.errors) {
            errors.errors[i] = errors.errors[i].join(" | ");
        }
        return errors;
    }

    return { message: errors };
};
