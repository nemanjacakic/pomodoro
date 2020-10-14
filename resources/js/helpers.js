function buildFormData(formData, data, parentKey) {
  if (
    data &&
    typeof data === "object" &&
    !(data instanceof Date) &&
    !(data instanceof File)
  ) {
    Object.keys(data).forEach(key => {
      buildFormData(
        formData,
        data[key],
        parentKey ? `${parentKey}[${key}]` : key
      );
    });
  } else {
    const value = data == null ? "" : data;

    formData.append(parentKey, value);
  }
}

function objectToFormData(data) {
  const formData = new FormData();

  buildFormData(formData, data);

  return formData;
}

function notEmpty(string) {
  return string !== "" && string !== null;
}

function playSound(sound) {
  const audio = new Audio(sound);
  audio.play();
}

export { objectToFormData, notEmpty, playSound };
