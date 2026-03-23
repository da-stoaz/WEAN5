export type DevicePayload = {
  deviceName: string;
  manufacturer: string;
  serialNumber?: string | null;
  description?: string | null;
};

export type Device = DevicePayload & {
  id: string;
};

type RawDevice = Partial<DevicePayload> & {
  id?: string;
  deviceId?: string;
};

function normalizeDevice(raw: RawDevice): Device {
  const id = raw.id ?? raw.deviceId ?? "";

  return {
    id,
    deviceName: raw.deviceName ?? "Unnamed device",
    manufacturer: raw.manufacturer ?? "Unknown",
    serialNumber: raw.serialNumber ?? null,
    description: raw.description ?? null,
  };
}

async function request<T>(
  baseUrl: string,
  path: string,
  init?: RequestInit,
): Promise<T> {
  const response = await fetch(`${baseUrl}${path}`, {
    ...init,
    headers: {
      "Content-Type": "application/json",
      ...(init?.headers ?? {}),
    },
  });

  if (!response.ok) {
    const text = await response.text();
    throw new Error(text || `Request failed with status ${response.status}`);
  }

  const bodyText = await response.text();
  if (!bodyText) {
    return undefined as T;
  }

  return JSON.parse(bodyText) as T;
}

export async function getDevices(baseUrl: string): Promise<Device[]> {
  const raw = await request<RawDevice[]>(baseUrl, "/devices");
  if (!Array.isArray(raw)) {
    return [];
  }

  return raw
    .map(normalizeDevice)
    .filter((device) => device.id.length > 0)
    .sort((a, b) => a.deviceName.localeCompare(b.deviceName));
}

export async function createDevice(
  baseUrl: string,
  payload: DevicePayload,
): Promise<void> {
  await request(baseUrl, "/devices", {
    method: "POST",
    body: JSON.stringify(payload),
  });
}

export async function updateDevice(
  baseUrl: string,
  id: string,
  payload: DevicePayload,
): Promise<void> {
  await request(baseUrl, `/devices/${id}`, {
    method: "PUT",
    body: JSON.stringify(payload),
  });
}

export async function deleteDevice(baseUrl: string, id: string): Promise<void> {
  await request(baseUrl, `/devices/${id}`, {
    method: "DELETE",
  });
}
