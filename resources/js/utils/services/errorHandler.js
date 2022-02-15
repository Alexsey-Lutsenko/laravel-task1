module.exports = (e) => {
    const errors = e.response ? e.response.data.errors : e.message;

    if (e.response) {
        for (let i in errors) {
            errors[i] = errors[i].join(" | ");
        }
        return errors;
    }

    return { message: errors };
};
